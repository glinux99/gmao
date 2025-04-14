<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipmentApiController extends Controller
{
     /**
     * Display a listing of the equipment.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $equipments = Equipment::with(['project', 'user'])->get();
        return response()->json(['data' => $equipments]);
    }

    /**
     * Store a newly created equipment in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // // Validation rules
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'serial_number' => 'nullable|string|unique:equipments|max:255',
        //     'status' => 'nullable|string|max:255',
        //     'description' => 'nullable|string',
        //     'project_id' => 'nullable|exists:projects,id',
        //     'user_id' => 'nullable|exists:users,id',
        //     'purchase_date' => 'nullable|date',
        //     'purchase_price' => 'nullable|numeric|between:0,999999.99',
        //     'warranty_end_date' => 'nullable|date',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

       try {
        //code...
        $equipment = Equipment::create($request->all());
       } catch (\Throwable $th) {
        //throw $th;
        return response()->json(['errors' => $th], 422);
       }
        return response()->json(['data' => $equipment], 201);
    }

    /**
     * Display the specified equipment.
     *
     * @param  Equipment  $equipment
     * @return JsonResponse
     */
    public function show(Equipment $equipment): JsonResponse
    {
        $equipment->load(['project', 'user']);
        return response()->json(['data' => $equipment]);
    }

    /**
     * Update the specified equipment in storage.
     *
     * @param  Request  $request
     * @param  Equipment  $equipment
     * @return JsonResponse
     */
    public function update(Request $request, Equipment $equipment): JsonResponse
    {
        // // Validation rules (similar to store, but no need to check for uniqueness if it's the same serial_number)
        // $validator = Validator::make($request->all(), [
        //     'name' => 'sometimes|required|string|max:255',
        //     'serial_number' => 'sometimes|nullable|string|max:255|unique:equipments,serial_number,' . $equipment->id,
        //     'status' => 'sometimes|nullable|string|max:255',
        //     'description' => 'sometimes|nullable|string',
        //     'project_id' => 'sometimes|nullable|exists:projects,id',
        //     'user_id' => 'sometimes|nullable|exists:users,id',
        //     'purchase_date' => 'sometimes|nullable|date',
        //     'purchase_price' => 'sometimes|nullable|numeric|between:0,999999.99',
        //     'warranty_end_date' => 'sometimes|nullable|date',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 422);
        // }

        $equipment->update($request->all());
        return response()->json(['data' => $equipment]);
    }

    /**
     * Remove the specified equipment from storage.
     *
     * @param  Equipment  $equipment
     * @return JsonResponse
     */
    public function destroy(Equipment $equipment): JsonResponse
    {
        $equipment->delete();
        return response()->json(['message' => 'Equipment deleted']);
    }
}
