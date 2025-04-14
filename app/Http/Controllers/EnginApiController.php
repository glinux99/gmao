<?php

namespace App\Http\Controllers;

use App\Models\Engin;
use App\Models\EnginDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EnginApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $engins = Engin::with('region', 'engin_details')->get();
        return response()->json(['data' => $engins]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'nullable|string',
                'matricule' => 'nullable|string',
                'region_id' => 'nullable|exists:regions,id',
                'user_id' => 'nullable|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $request['user_id']= Auth::user()->id;
            $engin = Engin::create($request->all());
            EnginDetails::create(['engin_id' =>  $engin->id, 'kilometrage_debut'=> $request->kilometrage_debut, 'kilometrage_fin'=> $request->kilometrage_fin]);
            return response()->json(['data' => $engin], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Engin $engin)
    {
        $engin->load('region');
        return response()->json(['data' => $engin]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Engin $engin)
    {
       try {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'matricule' => 'nullable|string',
            'region_id' => 'nullable|exists:regions,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $engin->update($request->all());
        EnginDetails::create(['engin_id' =>  $engin->id, 'kilometrage_debut'=> $request->get('kilometrage_debut'), 'kilometrage_fin'=> $request->get('kilometrage_fin')]);
        return response()->json(['data' => $engin]);
       } catch (\Throwable $th) {
        //throw $th;
        return $th->getMessage();
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Engin $engin)
    {
        $engin->delete();
        return response()->json(['message' => 'Engin deleted successfully'], 200);
    }
}
