<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Task; // Import the Task model
use Illuminate\Http\Request;

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
            // Validate the incoming request data
            // $validatedData = $request->validate([
            //     'equipment_id' => 'required|exists:equipments,id',
            //     'work_order' => 'required|string|max:255',
            //     'man_hours' => 'required|numeric',
            //     'maintenance_cost' => 'required|numeric',
            //     'start_date' => 'required|date',
            //     'end_date' => 'nullable|date',
            //     'description' => 'required|string|max:255',
            //     'status' => 'required|in:pending,in_progress,completed',
            //     'user_id' => 'required|exists:users,id',
            // ]);

            // Create the maintenance record
            $maintenance = Maintenance::create($request->all());

            // Create a related task
            $taskData = [
                'description' => 'Maintenance: ' . $maintenance->description, // Task description based on maintenance
                'priority' => 'Moyen', // You can set a default priority
                'status' => 'pending', // Default task status
                'user_id' => $maintenance->user_id, // Assign the task to the maintenance's user
                'start_date' => $maintenance->start_date,
                'due_date' => $maintenance->end_date,
                'type'=>'Maintenance'
                 // Other task fields as needed
            ];
            $task= Task::create($taskData);
        } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

        return response()->json(['data' => $maintenance]);
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
            $validatedData = $request->validate([
                'equipment_id' => 'required|exists:equipments,id',
                'work_order' => 'required|string|max:255',
                'man_hours' => 'required|numeric',
                'maintenance_cost' => 'required|numeric',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date',
                'description' => 'required|string|max:255',
                'status' => 'required|in:pending,in_progress,completed',
                'user_id' => 'required|exists:users,id',
            ]);
            $maintenance->update($validatedData);

             return response()->json(['data' => $maintenance]);
        } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
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
