<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Task;
use App\Models\Material;
use App\Models\Category;
use App\Models\Instruction;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Maintenance::with(['equipment', 'user']);

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

            $maintenances = $query->get();
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
            $maintenance = Maintenance::create($request->except(['techniciens','materials','instructions']));

            // Assign technicians if provided
            if ($request->has('techniciens')) {
                $maintenance->technicians()->attach($request->techniciens);
            }
             // Handle materials
            if ($request->has('materials')) {
                foreach ($request->materials as $materialData) {
                    $material = Material::find($materialData['material_id']);
                    if ($material) {
                        $maintenance->materials()->attach($material, ['quantity' => $materialData['quantity']]);
                    }
                }
            }
            // Handle instructions
            if ($request->has('instructions')) {
                foreach ($request->instructions as $instructionData) {
                    $instruction = new Instruction($instructionData);
                    $maintenance->instructions()->save($instruction);
                }
            }

            // Split the description into individual tasks
            $tasksString = $request->description;
            $tasksArray = explode(';', $tasksString);

            foreach ($tasksArray as $taskDescription) {
                // Trim whitespace from the task description
                $taskDescription = trim($taskDescription);

                // Check if the task description is not empty
                if (!empty($taskDescription)) {
                    // Create a related task for each description
                    $taskData = [
                        'description' => 'Maintenance sur l\'équipement ' . $maintenance->equipment->name ?? "N/A" . ' : ' . $taskDescription, // Task description based on maintenance
                        'priority' => 'Moyen', // You can set a default priority
                        'status' => 'pending', // Default task status
                        'user_id' => $maintenance->user_id, // Assign the task to the maintenance's user
                        'start_date' => $maintenance->start_date,
                        'due_date' => $maintenance->end_date,
                        'type' => 'Maintenance',
                        "category"=> "Préventive",
                        'project_id' => $maintenance->equipment->project_id ?? null,
                        'owner_id' => $maintenance->user_id
                        // Other task fields as needed
                    ];
                   $task = Task::create($taskData);
                    $this->sendTaskNotifications($task, $maintenance);
                }
            }
            DB::commit();

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
                return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }

        return response()->json(['data' => $maintenance->load(['technicians','materials','instructions'])]);
    }
    protected function sendTaskNotifications(Task $task, Maintenance $maintenance)
    {
        // Get the responsible user (assigned user)
        $responsibleUser = $task->user;

        // Get the owner of the task
        $owner = $task->owner;

        // Get the technicians associated with the maintenance
        $technicians = $maintenance->technicians;

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
                $user->notify(new TaskAssignedNotification($task, $user, []));
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
         try {
            $maintenance->load(['equipment', 'user']); // Eager load relationships
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
            // Sync technicians
            if ($request->has('techniciens')) {
                $maintenance->technicians()->sync($request->techniciens);
            }
            // Sync materials
            $maintenance->materials()->detach();
            if ($request->has('materials')) {
                foreach ($request->materials as $materialData) {
                    $material = Material::find($materialData['material_id']);
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
            DB::commit();
             return response()->json(['data' => $maintenance->load(['technicians','materials','instructions'])]);
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
