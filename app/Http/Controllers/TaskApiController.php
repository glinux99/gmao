<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskApiController extends Controller
{

    public function index()
    {
        $tasks = Task::with('project', 'instructions')->get(); // Eager load instructions
        return response()->json(['data' => $tasks]);
    }
    public function show(Task $task)
    {
        $task->load('project', 'instructions'); // Eager load instructions
        return response()->json(['data' => $task]);
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $taskData = $request->except('instructions');
            $task = Task::create($taskData);

            // Create instructions
            if ($request->has('instructions')) {
                foreach ($request->input('instructions') as $instructionData) {
                    $task->instructions()->create($instructionData);
                }
            }

            DB::commit();
            return response()->json(['data' => $task], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request, Task $task)
    {
        DB::beginTransaction();
        try {
            $taskData = $request->except('instructions');
            $task->update($taskData);

            // Update or create instructions
            if ($request->has('instructions')) {
                // Delete existing instructions
                $task->instructions()->delete();

                // Create new instructions
                foreach ($request->input('instructions') as $instructionData) {
                    $task->instructions()->create($instructionData);
                }
            }
            DB::commit();
            return response()->json(['data' => $task]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
