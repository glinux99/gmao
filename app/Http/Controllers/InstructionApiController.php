<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use Illuminate\Http\Request;

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

    public function update(Request $request, Instruction $instruction)
    {
        $instruction->update($request->all());
        return response()->json(['data' => $instruction]);
    }

    public function destroy(Instruction $instruction)
    {
        $instruction->delete();
        return response()->json(null, 204);
    }
}
