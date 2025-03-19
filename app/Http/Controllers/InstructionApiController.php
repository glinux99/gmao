<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstructionApiController extends Controller
{
    public function index(Request $request)
    {
        $taskId = $request->query('task_id');
        if ($taskId) {
            $instructions = Instruction::where('task_id', $taskId)->get();
        } else {
            $instructions = Instruction::all();
        }
        return response()->json(['data' => $instructions]);
    }

    public function store(Request $request)
    {
        $instruction = Instruction::create($request->all());
        return response()->json(['data' => $instruction], 201);
    }

    public function show(Instruction $instruction)
    {
        return response()->json(['data' => $instruction]);
    }

    public function destroy(Instruction $instruction)
    {
        $instruction->delete();
        return response()->json(null, 204);
    }
    public function updateInstructions(Request $request, Task $task)
    {
        // Validate the request (optional, but recommended)
        $request->validate([
            'value' => 'array',
            'value.*' => 'nullable|string',
        ]);

        // Get the instruction responses from the request
        $instructionResponses = $request->input('value', []);

        // Loop through the instructions and update the responses
        foreach ($task->instructions as $instruction) {
            $response = $instructionResponses[$instruction->id] ?? null;
            $instruction->update(['response' => $response]);
        }

        // Redirect back to the task show page
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        // Find the instruction
        $instruction = Instruction::find($id);

        if (!$instruction) {
            return response()->json(['message' => 'Instruction not found'], 404);
        }

        // Update the value
        $instruction->value = $request->input('value');
        $instruction->save();

        return response()->json(['message' => 'Instruction updated successfully', 'instruction' => $instruction], 200);
    }
    /**
     * Update the specified resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAll(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'instructions' => 'required|array',
            'instructions.*.id' => 'required|exists:instructions,id',
            'instructions.*.value' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $instructionsData = $request->input('instructions');

        foreach ($instructionsData as $instructionData) {
            $instruction = Instruction::find($instructionData['id']);

            if (!$instruction) {
                return response()->json(['message' => 'Instruction not found'], 404);
            }

            $instruction->value = $instructionData['value'];
            $instruction->save();
        }

        return response()->json(['message' => 'Instructions updated successfully'], 200);
    }
}
