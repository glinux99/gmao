<?php

namespace App\Http\Controllers;

use App\Imports\MaintenanceImport;
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
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Exceptions\SheetNotFoundException;
use Maatwebsite\Excel\Facades\Excel;
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
            }, 'instructions', 'region','documents']);

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
     * Calculate the number of tasks and their dates based on frequency.
     *
     * @param array $tasksData
     * @param string $startDate
     * @param string $endDate
     * @param string $frequency
     * @return array
     */
    protected function calculateTasksDates(array $tasksData, string $startDate, string $endDate, string $frequency): array
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $tasksToCreate = [];

        // determine the number of tasks that need to be created based on the frequency
         $numberOfTasks = match ($frequency) {
            'daily' => $start->diffInDays($end) + 1,
            'weekly' => $start->diffInWeeks($end) + 1,
            'bimonthly' => $start->diffInMonths($end) / 2 + 1,
            'quarterly' => $start->diffInQuarters($end) + 1,
            'biannual' => $start->diffInMonths($end) / 6 + 1,
            'annual' => $start->diffInYears($end) + 1,
            default => 1, // Default to 1 task if frequency is not recognized
        };
        $numberOfTasks=1; //REMOVE THIS LINE
        // Iterate over each original task to calculate start and due dates
        foreach ($tasksData as $originalTask) {
            for ($i = 0; $i < $numberOfTasks; $i++) {
                // Determine the start and due dates for the current task iteration
                $taskStartDate = match ($frequency) {
                    'daily' => $start->copy()->addDays($i),
                    'weekly' => $start->copy()->addWeeks($i),
                    'bimonthly' => $start->copy()->addMonths($i * 2),
                    'quarterly' => $start->copy()->addQuarters($i),
                    'biannual' => $start->copy()->addMonths($i * 6),
                    'annual' => $start->copy()->addYears($i),
                    default => $start->copy(), // Default to start date
                };
                $taskDueDate = $taskStartDate->copy();

                // Clone the original task and modify it
                $newTask = $originalTask;
                $newTask['start_date'] = $taskStartDate->format('Y-m-d H:i:s');
                $newTask['due_date'] = $taskDueDate->format('Y-m-d H:i:s');
                $tasksToCreate[] = $newTask;
            }
        }

        return $tasksToCreate;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'region_id' => 'nullable|exists:regions,id',
            'status' => 'nullable|in:pending,in_progress,completed,canceled',
            'work_order' => 'nullable|string|max:255',
            'equipment_id' => 'nullable|exists:equipments,id',
            'user_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            // 'end_date' => 'nullable|date|after:start_date',
            'man_hours' => 'nullable|integer|min:0',
            'delay' => 'nullable|string',
            'maintenance_cost' => 'nullable|numeric|min:0',
            'rappel' => 'nullable|integer|min:0',
            'type' => 'required|in:equipment,quarterly',
            'frequency' => 'required|in:daily,weekly,bimonthly,quarterly,biannual,annual,custom',
            'daysOfWeek' => 'nullable|array',
            'daysOfWeek.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'nbre_tacherons' => 'nullable|integer|min:0',
            'price_technicien' => 'nullable|numeric|min:0',
            'expenses' => 'nullable|array',
            'expenses.*.title' => 'required|string',
            'expenses.*.amount' => 'required|numeric|min:0',
            'instructions' => 'nullable|array',
            'instructions.*.description' => 'required|string',
            'instructions.*.response_type' => 'required|string',
            'tasks' => 'nullable|array',
            'tasks.*.description' => 'required|string',
            'tasks.*.owner' => 'nullable|exists:users,id',
            'tasks.*.user_id' => 'nullable|exists:users,id',
            'tasks.*.status' => 'required|in:pending,in_progress,completed,canceled',
            'tasks.*.priority_id' => 'required|exists:priorities,id',
            'tasks.*.project_id' => 'nullable|exists:projects,id',
            'tasks.*.assignToType' => 'required|in:user,team',
            'tasks.*.assigned_user_id' => 'nullable|exists:users,id',
            'tasks.*.assigned_team_id' => 'nullable|exists:teams,id',
            'tasks.*.nbre_tacherons' => 'nullable|integer|min:0',
            'tasks.*.price_tacherons' => 'nullable|numeric|min:0',
            'tasks.*.instructions' => 'nullable|array',
            'tasks.*.instructions.*.description' => 'required|string',
            'tasks.*.instructions.*.response_type' => 'required|string',
            'tasks.*.materials' => 'nullable|array',
            'tasks.*.materials.*.id' => 'required|exists:categories,id',
            'tasks.*.materials.*.quantity' => 'required|integer|min:1',
            'materials' => 'nullable|array',
            'materials.*.id' => 'required|exists:categories,id',
            'materials.*.quantity' => 'required|integer|min:1',
        ], [
            'description.required' => 'La description de la maintenance est obligatoire.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.',
            'region_id.exists' => 'La région sélectionnée n\'existe pas.',
            'status.in' => 'Le statut doit être parmi : pending, in_progress, completed, canceled.',
            'work_order.max' => 'Le numéro de bon de travail ne doit pas dépasser 255 caractères.',
            'equipment_id.exists' => 'L\'équipement sélectionné n\'existe pas.',
            'user_id.exists' => 'L\'utilisateur sélectionné n\'existe pas.',
            'start_date.required' => 'La date de début est obligatoire.',
            'start_date.date' => 'La date de début doit être une date valide.',
            'end_date.date' => 'La date de fin doit être une date valide.',
            // 'end_date.after' => 'La date de fin doit être postérieure à la date de début.',
            'man_hours.integer' => 'Les heures-homme doivent être un nombre entier.',
            'man_hours.min' => 'Les heures-homme doivent être au moins 0.',
            'maintenance_cost.numeric' => 'Le coût de maintenance doit être un nombre.',
            'maintenance_cost.min' => 'Le coût de maintenance doit être au moins 0.',
            'rappel.integer' => 'Le rappel doit être un nombre entier.',
            'rappel.min' => 'Le rappel doit être au moins 0.',
            'type.in' => 'Le type doit être soit "equipment", soit "quarterly".',
            'type.required' => 'Le type est obligatoire.',
            'frequency.in' => 'La fréquence doit être parmi : daily, weekly, bimonthly, quarterly, biannual, annual, custom.',
            'frequency.required' => 'La fréquence est obligatoire.',
            'daysOfWeek.array' => 'Les jours de la semaine doivent être un tableau.',
            'daysOfWeek.*.in' => 'Un jour de la semaine doit être parmi : monday, tuesday, wednesday, thursday, friday, saturday, sunday.',
            'nbre_tacherons.integer' => 'Le nombre de tacherons doit être un nombre entier.',
            'nbre_tacherons.min' => 'Le nombre de tacherons doit être au moins 0.',
            'price_technicien.numeric' => 'Le prix du technicien doit être un nombre.',
            'price_technicien.min' => 'Le prix du technicien doit être au moins 0.',
            'expenses.array' => 'Les dépenses doivent être un tableau.',
            'expenses.*.title.required' => 'Le titre de la dépense est obligatoire.',
            'expenses.*.title.string' => 'Le titre de la dépense doit être une chaîne de caractères.',
            'expenses.*.amount.required' => 'Le montant de la dépense est obligatoire.',
            'expenses.*.amount.numeric' => 'Le montant de la dépense doit être un nombre.',
            'expenses.*.amount.min' => 'Le montant de la dépense doit être au moins 0.',
            'instructions.array' => 'Les instructions doivent être un tableau.',
            'instructions.*.description.required' => 'La description de l\'instruction est obligatoire.',
            'instructions.*.description.string' => 'La description de l\'instruction doit être une chaîne de caractères.',
            'instructions.*.response_type.required' => 'Le type de réponse de l\'instruction est obligatoire.',
            'instructions.*.response_type.string' => 'Le type de réponse de l\'instruction doit être une chaîne de caractères.',
            'tasks.array' => 'Les tâches doivent être un tableau.',
            'tasks.*.description.required' => 'La description de la tâche est obligatoire.',
            'tasks.*.description.string' => 'La description de la tâche doit être une chaîne de caractères.',
            'tasks.*.owner.exists' => 'Le propriétaire de la tâche sélectionné n\'existe pas.',
            'tasks.*.user_id.exists' => 'L\'utilisateur de la tâche sélectionné n\'existe pas.',
            'tasks.*.status.in' => 'Le statut de la tâche doit être parmi : pending, in_progress, completed, canceled.',
            'tasks.*.status.required' => 'Le statut de la tâche est obligatoire.',
            'tasks.*.priority_id.exists' => 'La priorité de la tâche sélectionnée n\'existe pas.',
            'tasks.*.priority_id.required' => 'La priorité de la tâche est obligatoire.',
            'tasks.*.project_id.exists' => 'Le projet de la tâche sélectionné n\'existe pas.',
            'tasks.*.assignToType.in' => 'Le type d\'assignation de la tâche doit être soit "user", soit "team".',
            'tasks.*.assignToType.required' => 'Le type d\'assignation de la tâche est obligatoire.',
            'tasks.*.assigned_user_id.exists' => 'L\'utilisateur assigné à la tâche sélectionné n\'existe pas.',
            'tasks.*.assigned_team_id.exists' => 'L\'équipe assignée à la tâche sélectionnée n\'existe pas.',
            'tasks.*.nbre_tacherons.integer' => 'Le nombre de tacherons de la tâche doit être un nombre entier.',
            'tasks.*.nbre_tacherons.min' => 'Le nombre de tacherons de la tâche doit être au moins 0.',
            'tasks.*.price_tacherons.numeric' => 'Le prix des tacherons de la tâche doit être un nombre.',
            'tasks.*.price_tacherons.min' => 'Le prix des tacherons de la tâche doit être au moins 0.',
            'tasks.*.instructions.array' => 'Les instructions de la tâche doivent être un tableau.',
            'tasks.*.instructions.*.description.required' => 'La description de l\'instruction de la tâche est obligatoire.',
            'tasks.*.instructions.*.description.string' => 'La description de l\'instruction de la tâche doit être une chaîne de caractères.',
            'tasks.*.instructions.*.response_type.required' => 'Le type de réponse de l\'instruction de la tâche est obligatoire.',
            'tasks.*.instructions.*.response_type.string' => 'Le type de réponse de l\'instruction de la tâche doit être une chaîne de caractères.',
            'tasks.*.materials.array' => 'Les matériaux de la tâche doivent être un tableau.',
            'tasks.*.materials.*.id.required' => 'L\'ID du matériau de la tâche est obligatoire.',
            'tasks.*.materials.*.id.exists' => 'Le matériau de la tâche sélectionné n\'existe pas.',
            'tasks.*.materials.*.quantity.required' => 'La quantité du matériau de la tâche est obligatoire.',
            'tasks.*.materials.*.quantity.integer' => 'La quantité du matériau de la tâche doit être un nombre entier.',
            'tasks.*.materials.*.quantity.min' => 'La quantité du matériau de la tâche doit être au moins 1.',
            'materials.array' => 'Les matériaux doivent être un tableau.',
            'materials.*.id.required' => 'L\'ID du matériau est obligatoire.',
            'materials.*.id.exists' => 'Le matériau sélectionné n\'existe pas.',
            'materials.*.quantity.required' => 'La quantité du matériau est obligatoire.',
            'materials.*.quantity.integer' => 'La quantité du matériau doit être un nombre entier.',
            'materials.*.quantity.min' => 'La quantité du matériau doit être au moins 1.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->has('tasks') && is_array($request->tasks) && Count($request->tasks)>0){
            try {
                DB::beginTransaction();

                // Create the maintenance record
                $maintenanceData = $request->except(['daysOfWeek', 'techniciens', 'materials', 'instructions', 'tasks', 'expenses']);
                $maintenance = Maintenance::create($maintenanceData);

                // Handle Expenses
                $allDep = Depense::where('maintenance_id', $maintenance->id)->get();
                foreach ($allDep as $dep) {
                    $dep->delete();
                }
                if ($request->expenses) {
                    foreach ($request->expenses as $expense) {
                        $expense['maintenance_id'] = $maintenance->id;
                        Depense::create($expense);
                    }
                }

                $maintenance->load('equipment');

                // Assign technicians if provided
                if ($request->has('techniciens')) {
                    $maintenance->technicians()->attach($request->techniciens);
                }

                // Handle materials for maintenance
                if ($request->materials) {
                    foreach ($request->materials as $materialData) {
                        $material = Category::find($materialData['id']);
                        if ($material) {
                            $maintenance->materials()->attach($material, ['quantity' => $materialData['quantity']]);
                        }
                    }
                }

                // Handle instructions for maintenance
                if ($request->instructions && Count($request->instructions) > 0) {
                    foreach ($request->instructions as $instructionData) {
                        $instructionData['maintenance_id'] = $maintenance->id;
                        $instruction = new Instruction($instructionData);
                        $maintenance->instructions()->save($instruction);
                    }
                }

                // Handle tasks
                if ($request->has('tasks') && is_array($request->tasks)) {
                    $tasksToCreate=$this->calculateTasksDates($request->tasks, $maintenance->start_date, $maintenance->end_date, $maintenance->frequency);
                    foreach ($tasksToCreate as $taskData) {

                        $taskData['maintenance_id'] = $maintenance->id;
                        $taskData['owner'] = $request->owner;
                        $taskData['user_id'] = $request->user_id;
                        $taskData['status'] = 'pending';
                        $taskData['region_id']= $maintenance->region_id;
                        $task = Task::create($taskData);

                        // Handle instructions for each task
                        if (isset($taskData['instructions']) && is_array($taskData['instructions'])) {
                            foreach ($taskData['instructions'] as $instructionData) {
                                $instructionData['task_id'] = $task->id;
                                Instruction::create($instructionData);
                            }
                        }

                        // Handle materials for each task
                        if (isset($taskData['materials']) && is_array($taskData['materials'])) {
                            foreach ($taskData['materials'] as $materialData) {
                                $material = Category::find($materialData['id']);
                                if ($material) {
                                    $task->materials()->attach($material, ['quantity' => $materialData['quantity']]);
                                }
                            }
                        }
                        //assign user to task
                        if(isset($taskData['assigned_user_id']) && $taskData['assignToType'] == 'user'){
                            $task->assigned_user_id = $taskData['assigned_user_id'];
                            $task->assigned_team_id = null;
                            $task->save();
                        }
                        //assign team to task
                        if(isset($taskData['assigned_team_id']) && $taskData['assignToType'] == 'team'){
                            $task->assigned_team_id = $taskData['assigned_team_id'];
                            $task->assigned_user_id = null;
                            $task->save();
                        }
                    }
                }

                // Schedule next tasks if frequency is set
                // if ($maintenance->frequency ) {
                //     $this->scheduleNextTasks($maintenance);
                // }

                DB::commit();
                return response()->json(['data' => $maintenance->load(['technicians', 'materials' => function ($query) {
                    $query->select('categories.*', 'maintenance_material.quantity');
                }, 'instructions', 'tasks.instructions', 'tasks.materials'])]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                DB::rollBack();
                return response()->json(['errors' => $e->errors()], 422);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error($th->getMessage());
                return response()->json(['error' => $th->getMessage()], 500);
            }
        }else{

        try {
            DB::beginTransaction();
            // Create the maintenance record
            $maintenance = Maintenance::create($request->except(['daysOfWeek', 'techniciens', 'materials', 'instructions']));
            // return $maintenance->id;
            $allDep = Depense::where('maintenance_id', $maintenance->id)->get();
            foreach ($allDep as $dep) {
                $dep->delete();
            }
            foreach ($request->expenses as $expense) {
                $expense['maintenance_id'] = $maintenance->id;
                Depense::create($expense);
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

            // Handle instructions

            if ($request->instructions && Count($request->instructions) > 0) {
                foreach ($request->instructions as $instructionData) {
                    $instructionData['maintenance_id'] = $maintenance->id; //no necessary line
                    $instruction = new Instruction($instructionData);
                    $maintenance->instructions()->save($instruction);
                }
            }

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

    }

    protected function createTaskFromMaintenance(Maintenance $maintenance, $start_date, $due_date)
    {
        //dd($start_date);
        $end_date = Carbon::parse($start_date)->addHours((int) $maintenance->man_hours);
        $taskData = [
            'description' => 'Maintenance sur l\'équipement ' . ($maintenance->equipment->name ?? "N/A") . ' : ' . $maintenance->description,
            'priority_id' => 2, // Default priority to Moyen
            'status' => 'planned',
            'user_id' => $maintenance->user_id,
            'assigned_user_id' => $maintenance->assigned_user_id,
            'assigned_team_id' => $maintenance->assigned_team_id,
            'equipment_id' => $maintenance->equipment_id,
            'start_date' => $start_date,
            'due_date' => $end_date->format('Y-m-d H:i:s'), // Use $end_date here
            'type' => 'Maintenance',
            "region_id" =>  $maintenance->region_id,
            'maintenance_id' => $maintenance->id,
            'project_id' => $maintenance->equipment->project_id ?? null,
            'owner' => $maintenance->owner,
        ];
        $task = Task::create($taskData);
        $instructions = Instruction::where('maintenance_id', $maintenance->id)->get();
        foreach ($instructions as $instruction) {
            $instruction['task_id'] = $task->id;
            Instruction::create([
                'task_id' => $task->id,
                'description' => $instruction->description,
                'response_type' => $instruction->response_type,
                'value' => $instruction->value
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
        $t = $start_date->microsecond;

        while ($currentDate->lte($end_date)) {
            // Set the time components
            $currentDateTime = $currentDate->copy()->setTime($h, $m, $s, $t);

            $taskStartDate = $currentDateTime->format('Y-m-d H:i:s');
            $due_date = $currentDateTime->copy(); // Create a copy for due date calculation

            $task = $this->createTaskFromMaintenance($maintenance, $taskStartDate, $due_date);

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
                    $t = $start_date->microsecond;
                     // Set the time components
                    $currentDateTime = $currentDate->copy()->setTime($h, $m, $s, $t);

                    $taskStartDate = $currentDateTime->format('Y-m-d H:i:s');
                    $due_date = $currentDateTime->copy(); // Create a copy for due date calculation
                    $task = $this->createTaskFromMaintenance($maintenance, $taskStartDate, $due_date);
                }
                // Move to the next day
                $currentDate->addDay();
            }
        }
    }

    protected function scheduleBiMonthlyTasks(Maintenance $maintenance, Carbon $start_date, Carbon $end_date)
    {
        $h = $start_date->hour;
        $m = $start_date->minute;
        $s = $start_date->second;
        $t= $start_date->microsecond;
        $currentDate = $start_date->setTime($h, $m, $s, $t)->copy();
        while ($currentDate->lte($end_date)) {
            $currentDateTime = $currentDate->copy();

            $taskStartDate = $currentDateTime->format('Y-m-d H:i:s');
            $due_date = $currentDateTime->copy(); // Create a copy for due date calculation

            $task = $this->createTaskFromMaintenance($maintenance, $taskStartDate,$due_date);
            $currentDate->addMonth(2);
        }
    }

    protected function scheduleQuarterlyTasks(Maintenance $maintenance, Carbon $start_date, Carbon $end_date)
    {
        $currentDate = $start_date->copy();
        $h = $start_date->hour;
        $m = $start_date->minute;
        $s = $start_date->second;
        $t= $start_date->microsecond;
        while ($currentDate->lte($end_date)) {
              // Set the time components
              $currentDateTime = $currentDate->copy()->setTime($h, $m, $s, $t);

              $taskStartDate = $currentDateTime->format('Y-m-d H:i:s');
              $due_date = $currentDateTime->copy(); // Create a copy for due date calculation

            $task = $this->createTaskFromMaintenance($maintenance, $taskStartDate,$due_date);
            $currentDate->addQuarter();
        }
    }

    protected function scheduleBiannualTasks(Maintenance $maintenance, Carbon $start_date, Carbon $end_date)
    {
        $currentDate = $start_date->copy();
        $h = $start_date->hour;
        $m = $start_date->minute;
        $s = $start_date->second;
        $t= $start_date->microsecond;
        while ($currentDate->lte($end_date)) {
             // Set the time components
             $currentDateTime = $currentDate->copy()->setTime($h, $m, $s, $t);

             $taskStartDate = $currentDateTime->format('Y-m-d H:i:s');
             $due_date = $currentDateTime->copy(); // Create a copy for due date calculation
            $task = $this->createTaskFromMaintenance($maintenance, $taskStartDate,$due_date);
            $currentDate->addMonths(6);
        }
    }

    protected function scheduleAnnualTasks(Maintenance $maintenance, Carbon $start_date, Carbon $end_date)
    {
        $currentDate = $start_date->copy();
        $h = $start_date->hour;
        $m = $start_date->minute;
        $s = $start_date->second;
        $t= $start_date->microsecond;
        while ($currentDate->lte($end_date)) {
            $currentDateTime = $currentDate->copy()->setTime($h, $m, $s, $t);

            $taskStartDate = $currentDateTime->format('Y-m-d H:i:s');
            $due_date = $currentDateTime->copy(); // Create a copy for due date calculation
            $task = $this->createTaskFromMaintenance($maintenance, $taskStartDate,$due_date);
            $currentDate->addYear();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        $maintenance=Maintenance::with('tasks', 'region', 'expenses','documents')->find($maintenance->id);
        return response()->json(['data'=>$maintenance]);

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
    // public function update(Request $request, Maintenance $maintenance)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $maintenance->update($request->all());
    //         $depIds=[];
    //         $allDep = Depense::where('maintenance_id', $maintenance->id)->get();
    //         foreach($allDep as $dep){
    //             $dep->delete();
    //         }
    //         foreach($request->expenses  as $expense){
    //             $expense['maintenance_id']=$maintenance->id;
    //             // return $expense;
    //           if(isset($expense['readonly'])){
    //             $readOnly = Depense::where('maintenance_id', $maintenance->id)
    //             ->where('readonly', true)
    //             ->firstOrCreate($expense);
    //           }
    //           else{
    //             Depense::updateOrCreate($expense);
    //           }

    //         }

    //         // Sync technicians
    //         if ($request->has('techniciens')) {
    //             $maintenance->technicians()->sync($request->techniciens);
    //         }
    //         // Sync materials
    //         $maintenance->materials()->detach();
    //         if ($request->has('materials') && is_array($request->materials)) {
    //             foreach ($request->materials as $materialData) {
    //                 $material = Category::find($materialData['id']);
    //                 if ($material) {
    //                     $maintenance->materials()->attach($material, ['quantity' => $materialData['quantity']]);
    //                 }
    //             }
    //         }
    //         // Sync instructions
    //         $maintenance->instructions()->delete();
    //         if ($request->has('instructions')) {
    //             foreach ($request->instructions as $instructionData) {
    //                 $instruction = new Instruction($instructionData);
    //                 $maintenance->instructions()->save($instruction);
    //             }
    //         }
    //         //schedule the next task
    //         $tasks = Task::where('maintenance_id', $maintenance->id)
    //         ->where('status', '!=', 'completed')
    //         ->where('status', '!=', 'canceled')
    //         ->get();
    //         foreach($tasks as $task){
    //             $task->delete();
    //         }
    //         $this->scheduleNextTasks($maintenance);
    //         $duplicateTasks= Task::where('maintenance_id', $maintenance->id)
    //         ->select('start_date', 'due_date', DB::raw('count(*) as count'))
    //         ->groupBy('start_date', 'due_date')
    //         ->having('count', '>',1)->get();
    //         // return $duplicateTasks;
    //         foreach($duplicateTasks as $duplicateTask){
    //             $taskIds = Task::where('maintenance_id', $maintenance->id)
    //             ->where('start_date', $duplicateTask->start_date)
    //             ->where('due_date', $duplicateTask->due_date)
    //             ->pluck('id')
    //             ->toArray();
    //             array_shift($taskIds);
    //             Task::whereIn('id',$taskIds)->delete();
    //         }
    //         DB::commit();
    //         return response()->json(['data' => $maintenance->load(['technicians','expenses', 'materials' => function ($query) {
    //             $query->select('categories.*', 'maintenance_material.quantity');
    //         }, 'instructions'])]);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         DB::rollBack();
    //         return response()->json(['errors' => $e->errors()], 422);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         return response()->json(['error' => $th->getMessage()], 500);
    //     }
    // }
    public function update(Request $request, Maintenance $maintenance)
    {

        try {
            DB::beginTransaction();

            $maintenance->update($request->all());
            $depIds = [];
            $allDep = Depense::where('maintenance_id', $maintenance->id)->get();
            foreach ($allDep as $dep) {
                $dep->delete();
            }
            foreach ($request->expenses as $expense) {
                $expense['maintenance_id'] = $maintenance->id;
                if (isset($expense['readonly'])) {
                    $readOnly = Depense::where('maintenance_id', $maintenance->id)
                        ->where('readonly', true)
                        ->firstOrCreate($expense);
                } else {
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

            // Get current tasks for this maintenance
             $currentTasks = Task::where('maintenance_id', $maintenance->id)->get();
             //determine the tasks to create
             $tasksToCreate = $this->calculateTasksDates($request->tasks, $maintenance->start_date, $maintenance->end_date, $maintenance->frequency);
            // Delete existing tasks related to this maintenance
            Task::where('maintenance_id', $maintenance->id)->delete();

            foreach ($tasksToCreate as $taskData) {
                 $taskData['maintenance_id'] = $maintenance->id;
                 $taskData['owner'] = $request->owner;
                 $taskData['user_id'] = $request->user_id;
                 $taskData['status'] = 'pending';
                 $taskData['region_id'] = $maintenance->region_id;
                $task = Task::create($taskData);

                // Handle instructions for each task
                if (isset($taskData['instructions']) && is_array($taskData['instructions'])) {
                    foreach ($taskData['instructions'] as $instructionData) {
                        $instructionData['task_id'] = $task->id;
                        Instruction::create($instructionData);
                    }
                }

                // Handle materials for each task
                if (isset($taskData['materials']) && is_array($taskData['materials'])) {
                    foreach ($taskData['materials'] as $materialData) {
                        $material = Category::find($materialData['id']);
                        if ($material) {
                            $task->materials()->attach($material, ['quantity' => $materialData['quantity']]);
                        }
                    }
                }

                 //assign user to task
                 if (isset($taskData['assigned_user_id'])) {
                     $task->assigned_user_id = $taskData['assigned_user_id'];
                     $task->assigned_team_id = null;
                     $task->save();
                 }
                 //assign team to task
                 if (isset($taskData['assigned_team_id'])) {
                     $task->assigned_team_id = $taskData['assigned_team_id'];
                     $task->assigned_user_id = null;
                     $task->save();
                 }

            }

            // $duplicateTasks = Task::where('maintenance_id', $maintenance->id)
            //     ->select('start_date', 'due_date', DB::raw('count(*) as count'))
            //     ->groupBy('start_date', 'due_date')
            //     ->having('count', '>', 1)->get();

            // foreach ($duplicateTasks as $duplicateTask) {
            //     $taskIds = Task::where('maintenance_id', $maintenance->id)
            //         ->where('start_date', $duplicateTask->start_date)
            //         ->where('due_date', $duplicateTask->due_date)
            //         ->pluck('id')
            //         ->toArray();
            //     array_shift($taskIds);
            //     Task::whereIn('id', $taskIds)->delete();
            // }

            DB::commit();
            return response()->json(['data' => $maintenance->load(['technicians', 'expenses', 'materials' => function ($query) {
                $query->select('categories.*', 'maintenance_material.quantity');
            }, 'instructions', 'tasks'])]);
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
            DB::beginTransaction();

            // Delete related tasks
            $maintenance->tasks()->delete();

            // Delete related expenses
            $maintenance->expenses()->delete();

            // Delete related instructions
            $maintenance->instructions()->delete();

            // Detach related materials
            $maintenance->materials()->detach();

            // Detach related technicians
            $maintenance->technicians()->detach();

            // Finally, delete the maintenance record
            $maintenance->delete();

            DB::commit();
            return response()->json(['message' => 'Maintenance and related data deleted successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls',
            ]);

            $file = $request->file('file');

            try {

                $import = new MaintenanceImport ();
                Excel ::import($import, $file);

              return response()->json(['message' => 'Planning import successful!']);
        } catch (SheetNotFoundException $e) {
           return response()->json(['message' => 'Error importing Planning', 'error'=>$e->getMessage()], 500);
        }
       } catch (\Throwable $th) {
        //throw $th;
        return response()->json(['message'=>$th->getMessage()]);
       }
    }
}
