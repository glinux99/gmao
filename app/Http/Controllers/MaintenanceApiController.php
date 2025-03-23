<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Task;
use App\Models\Material;
use App\Models\Category;
use App\Models\Depense;
use App\Models\Instruction;
use App\Models\MaintenanceMaterial;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\Count;

class MaintenanceApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Maintenance::with(['equipment','tasks', 'user','expenses', 'materials' => function ($query) {
                $query->select('categories.*', 'maintenance_material.quantity');
            }, 'instructions']);

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('description', 'like', "%$search%")
                        ->orWhere('work_order', 'like', "%$search%")
                        ->orWhereHas('equipment', function ($eq) use ($search) {
                            $eq->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('user', function ($t) use ($search) {
                            $t->where('name', 'like', "%$search%");
                        });
                });
            }

            $maintenances = $query->get()->map(function ($maintenance) {
                $maintenance->materials = $maintenance->materials->map(function ($material) {
                    return [
                        'id' => $material->id,
                        'designation' => $material->designation,
                        'caracteristique' => $material->caracteristique,
                        'description' => $material->description,
                        'avatar' => $material->avatar,
                        'type' => $material->type,
                        'unity_id' => $material->unity_id,
                        'is_remise' => $material->is_remise,
                        'created_at' => $material->created_at,
                        'updated_at' => $material->updated_at,
                        'quantity' => $material->quantity,
                        'unity' => $material->unity,
                    ];
                });
                return $maintenance;
            });
            return response()->json(['data' => $maintenances]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // Create the maintenance record
            $maintenance = Maintenance::create($request->except(['daysOfWeek','techniciens', 'materials', 'instructions']));
            // return $maintenance->id;
            $allDep = Depense::where('maintenance_id', $maintenance->id)->get();
            foreach($allDep as $dep){
                $dep->delete();
            }
            foreach($request->expenses  as $expense){
                $expense['maintenance_id']=$maintenance->id;
                if(isset($expense['readonly'])){
                    $readOnly = Depense::where('maintenance_id', $maintenance->id)
                    ->where('readonly', 1)
                    ->first()->firstOrCreate($expense);
                  }
                  else{
                    Depense::updateOrCreate($expense);
                  }
            }
            $maintenance->load('equipment');

            // Assign technicians if provided
            if ($request->has('techniciens')) {
                $maintenance->technicians()->attach($request->techniciens);
            }

            // Handle materials
            if ($request->materials) {
                foreach ($request->materials as $materialData) {
                    $material = Category::find($materialData['id']);
                    if ($material) {
                        $maintenance->materials()->attach($material, ['quantity' => $materialData['quantity']]);
                    }
                }
            }

            // Create initial task if start_date is today
            // if (Carbon::parse($maintenance->start_date)->isToday()) {
            //     $task = $this->createTaskFromMaintenance($maintenance);
            //      // Handle instructions

                 if ($request->instructions && Count($request->instructions) > 0) {
                    foreach ($request->instructions as $instructionData) {
                        $instructionData['maintenance_id']= $maintenance->id;//no necessary line
                        $instruction = new Instruction($instructionData);
                        $maintenance->instructions()->save($instruction);
                    }
                }
            // }
            // Schedule next tasks
            // return $maintenance;/
            $this->scheduleNextTasks($maintenance);

            DB::commit();
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }

        return response()->json(['data' => $maintenance->load(['technicians', 'materials' => function ($query) {
            $query->select('categories.*', 'maintenance_material.quantity');
        }, 'instructions'])]);
    }

    protected function createTaskFromMaintenance(Maintenance $maintenance)
    {
        $end_date = Carbon::parse($maintenance->start_date)->addHours((int) $maintenance->man_hours);
        $taskData = [
            'description' => 'Maintenance sur l\'équipement ' . ($maintenance->equipment->name ?? "N/A") . ' : ' . $maintenance->description ,
            'priority_id' => 2, // Default priority to Moyen
            'status' => 'pending',
            'user_id' => $maintenance->assigned_user_id,
            'assigned_user_id' => $maintenance->assigned_user_id,
            'assigned_team_id' => $maintenance->assigned_team_id,
            'equipment_id' => $maintenance->equipment_id,
            'start_date' => $maintenance->start_date,
            'due_date' => $end_date,
            'type' => 'Maintenance',
            'maintenance_id'=>$maintenance->id,
            'project_id' => $maintenance->equipment->project_id ?? null,
            'owner' => $maintenance->assigned_user_id,
        ];
        $task = Task::create($taskData);
        $instructions = Instruction::where('maintenance_id', $maintenance->id)->get();
        foreach($instructions as $instruction){
            $instruction['task_id']=$task->id;
            Instruction::create([
                'task_id'=>$task->id,
                'description'=>$instruction->description,
                'response_type'=>$instruction->response_type,
                'value'=>$instruction->value
            ]);
        }
        $this->sendTaskNotifications($task, $maintenance);
        return $task;
    }

    protected function sendTaskNotifications(Task $task, Maintenance $maintenance)
    {
        // Get the responsible user (assigned user)
        $responsibleUser = $task->user;

        // Get the owner of the task
        $owner = User::find($task->owner);

        // Get the technicians associated with the maintenance
        $users = TeamUser::where('team_id', $task->assigned_team_id)->get();
        $technicians = [];
        foreach ($users as $key => $value) {
            $technicians[] = User::find($value->user_id);
        }


        // Collect email addresses
        $emails = [];
        if ($responsibleUser) {
            $emails[] = $responsibleUser->email;
        }
        if ($owner) {
            $emails[] = $owner->email;
        }
        foreach ($technicians as $technician) {
            $emails[] = $technician->email;
        }

        // Remove duplicate emails
        $emails = array_unique($emails);

        // Send the notification to each recipient
        foreach ($emails as $email) {
            // Find the user by email
            $user = \App\Models\User::where('email', $email)->first();

            if ($user) {
                try {
                    $user->notify(new TaskAssignedNotification($task, $user, []));
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
    }
    /**
     * Schedule tasks for maintenance based on its frequency.
     *
     * @param Maintenance $maintenance
     */
    protected function scheduleNextTasks(Maintenance $maintenance)
    {
        // Log::info('scheduling task for', $maintenance->toArray());
        if ($maintenance->frequency) {
            $start_date = Carbon::parse($maintenance->start_date);
            $end_date = Carbon::parse($maintenance->end_date);

            switch ($maintenance->frequency) {
                case 'daily':
                    $this->scheduleDailyTasks($maintenance, $start_date, $end_date);
                    break;
                case 'weekly':
                    $this->scheduleWeeklyTasks($maintenance, $start_date, $end_date);
                    break;
                case 'bimonthly':
                    $this->scheduleBiMonthlyTasks($maintenance, $start_date, $end_date);
                    break;
                case 'quarterly':
                    $this->scheduleQuarterlyTasks($maintenance, $start_date, $end_date);
                    break;
                case 'biannual':
                    $this->scheduleBiannualTasks($maintenance, $start_date, $end_date);
                    break;
                case 'annual':
                    $this->scheduleAnnualTasks($maintenance, $start_date, $end_date);
                    break;
                case 'custom':
                    // Schedule based on custom logic, if any
                    break;
            }
        }
    }

    protected function scheduleDailyTasks(Maintenance $maintenance, Carbon $start_date, Carbon $end_date)
    {
        $currentDate = $start_date->copy();
        $h = $start_date->hour;
        $m = $start_date->minute;
        $s = $start_date->second;
        while ($currentDate->lte($end_date)) {
            $task = $this->createTaskFromMaintenance($maintenance);
            $task->update([
                'start_date' => $currentDate->setTime($h, $m, $s)->format('Y-m-d H:i:s'),
                'due_date' =>  $currentDate->addHour((int) $maintenance->man_hours)->format('Y-m-d H:i:s'),
            ]);
            $currentDate->addDay();
        }
    }
    protected function scheduleWeeklyTasks(Maintenance $maintenance, Carbon $start_date, Carbon $end_date)
    {
        // Check if daysOfWeek is set and is an array
        if (isset($maintenance->daysOfWeek) && is_array($maintenance->daysOfWeek)) {
            $daysOfWeek = $maintenance->daysOfWeek;
            $currentDate = $start_date->copy();

            while ($currentDate->lte($end_date)) {
                // Get the name of the current day (e.g., "monday", "tuesday", etc.)
                $currentDayName = strtolower($currentDate->englishDayOfWeek);
                // Check if the current day is in the daysOfWeek array
                if (in_array($currentDayName, $daysOfWeek)) {
                    $h = $start_date->hour;
                    $m = $start_date->minute;
                    $s = $start_date->second;
                    $task = $this->createTaskFromMaintenance($maintenance);
                    $task->update([
                        'start_date' => $currentDate->setTime($h, $m, $s)->format('Y-m-d H:i:s'),
                        'due_date' =>  $currentDate->addHour((int) $maintenance->man_hours)->format('Y-m-d H:i:s'),
                    ]);
                }
                // Move to the next day
                $currentDate->addDay();
            }
        }
    }

    protected function scheduleBiMonthlyTasks(Maintenance $maintenance, Carbon $start_date, Carbon $end_date)
    {
        $currentDate = $start_date->copy();
        $h = $start_date->hour;
        $m = $start_date->minute;
        $s = $start_date->second;
        $t=$start_date->microsecond;
        while ($currentDate->lte($end_date)) {
            $task = $this->createTaskFromMaintenance($maintenance);
            $task->update([
                'start_date' => $currentDate->setTime($h, $m, $s,$t)->format('Y-m-d H:i:s'),
                'due_date' =>  $currentDate->addHour((int) $maintenance->man_hours)->format('Y-m-d H:i:s'),
            ]);
            $currentDate->addMonth(2);
        }
    }

    protected function scheduleQuarterlyTasks(Maintenance $maintenance, Carbon $start_date, Carbon $end_date)
    {
        $currentDate = $start_date->copy();
        $h = $start_date->hour;
        $m = $start_date->minute;
        $s = $start_date->second;
        while ($currentDate->lte($end_date)) {
            $task = $this->createTaskFromMaintenance($maintenance);
            $task->update([
                'start_date' => $currentDate->setTime($h, $m, $s)->format('Y-m-d H:i:s'),
                'due_date' =>  $currentDate->addHour((int) $maintenance->man_hours)->format('Y-m-d H:i:s'),
            ]);
            $currentDate->addQuarter();
        }
    }

    protected function scheduleBiannualTasks(Maintenance $maintenance, Carbon $start_date, Carbon $end_date)
    {
        $currentDate = $start_date->copy();
        $h = $start_date->hour;
        $m = $start_date->minute;
        $s = $start_date->second;
        while ($currentDate->lte($end_date)) {
            $task = $this->createTaskFromMaintenance($maintenance);
            $task->update([
                'start_date' => $currentDate->setTime($h, $m, $s)->format('Y-m-d H:i:s'),
                'due_date' =>  $currentDate->addHour((int) $maintenance->man_hours)->format('Y-m-d H:i:s'),
            ]);
            $currentDate->addMonths(6);
        }
    }

    protected function scheduleAnnualTasks(Maintenance $maintenance, Carbon $start_date, Carbon $end_date)
    {
        $currentDate = $start_date->copy();
        $h = $start_date->hour;
        $m = $start_date->minute;
        $s = $start_date->second;
        while ($currentDate->lte($end_date)) {
            $task = $this->createTaskFromMaintenance($maintenance);
            $task->update([
                'start_date' => $currentDate->setTime($h, $m, $s)->format('Y-m-d H:i:s'),
                'due_date' =>  $currentDate->addHour((int) $maintenance->man_hours)->format('Y-m-d H:i:s'),
            ]);
            $currentDate->addYear();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
        try {
            $maintenance->load(['equipment', 'user', 'materials' => function ($query) {
                $query->select('categories.*', 'maintenance_material.quantity');
            }, 'instructions']);

            $maintenance->materials = $maintenance->materials->map(function ($material) {
                return [
                    'id' => $material->id,
                    'designation' => $material->designation,
                    'caracteristique' => $material->caracteristique,
                    'description' => $material->description,
                    'avatar' => $material->avatar,
                    'type' => $material->type,
                    'unity_id' => $material->unity_id,
                    'is_remise' => $material->is_remise,
                    'created_at' => $material->created_at,
                    'updated_at' => $material->updated_at,
                    'quantity' => $material->quantity,
                    'unity' => $material->unity,
                ];
            });

            return response()->json(['data' => $maintenance]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        try {
            DB::beginTransaction();

            $maintenance->update($request->all());
            $depIds=[];
            $allDep = Depense::where('maintenance_id', $maintenance->id)->get();
            foreach($allDep as $dep){
                $dep->delete();
            }
            foreach($request->expenses  as $expense){
                $expense['maintenance_id']=$maintenance->id;
                // return $expense;
              if(isset($expense['readonly'])){
                $readOnly = Depense::where('maintenance_id', $maintenance->id)
                ->where('readonly', true)
                ->firstOrCreate($expense);
              }
              else{
                Depense::updateOrCreate($expense);
              }

            }

            // Sync technicians
            if ($request->has('techniciens')) {
                $maintenance->technicians()->sync($request->techniciens);
            }
            // Sync materials
            $maintenance->materials()->detach();
            if ($request->has('materials') && is_array($request->materials)) {
                foreach ($request->materials as $materialData) {
                    $material = Category::find($materialData['id']);
                    if ($material) {
                        $maintenance->materials()->attach($material, ['quantity' => $materialData['quantity']]);
                    }
                }
            }
            // Sync instructions
            $maintenance->instructions()->delete();
            if ($request->has('instructions')) {
                foreach ($request->instructions as $instructionData) {
                    $instruction = new Instruction($instructionData);
                    $maintenance->instructions()->save($instruction);
                }
            }
            //schedule the next task
            $tasks = Task::where('maintenance_id', $maintenance->id)
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'canceled')
            ->get();
            foreach($tasks as $task){
                $task->delete();
            }
            $this->scheduleNextTasks($maintenance);
            $duplicateTasks= Task::where('maintenance_id', $maintenance->id)
            ->select('start_date', 'due_date', DB::raw('count(*) as count'))
            ->groupBy('start_date', 'due_date')
            ->having('count', '>',1)->get();
            foreach($duplicateTasks as $duplicateTask){
                $taskIds = Task::where('maintenance_id', $maintenance->id)
                ->where('start_date', $duplicateTask->start_date)
                ->where('due_date', $duplicateTask->due_date)
                ->pluck('id')
                ->toArray();
                array_shift($taskIds);
                Task::whereIn('id',$taskIds)->delete();
            }
            DB::commit();
            return response()->json(['data' => $maintenance->load(['technicians','expenses', 'materials' => function ($query) {
                $query->select('categories.*', 'maintenance_material.quantity');
            }, 'instructions'])]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        try {
            $maintenance->delete();
            return response()->json(['message' => 'Maintenance deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
