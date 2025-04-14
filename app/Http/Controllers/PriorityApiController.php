<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PriorityApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priorities = Priority::all();
        return response()->json(['data' => $priorities]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $priority = Priority::create($request->all());
        return response()->json(['data' => $priority], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Priority $priority)
    {
        return response()->json(['data' => $priority]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Priority $priority)
    {


        $priority->update($request->all());
        return response()->json(['data' => $priority]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Priority $priority)
    {
        $priority->delete();
        return response()->json(null, 204);
    }
}
