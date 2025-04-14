<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Unity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnityApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
       try {
        $unities = Unity::all();

        return response()->json([
            'data' => $unities,
        ]);
       } catch (\Throwable $th) {
        //throw $th;
        return response()->json(['errors'=> $th->getMessage()]);
       }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUnityRequest  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $unity = Unity::create($request->validated());

        return response()->json([
            'data' => $unity,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Unity  $unity
     * @return JsonResponse
     */
    public function show(Unity $unity)
    {
        return response()->json([
            'data' => $unity,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUnityRequest  $request
     * @param  Unity  $unity
     * @return JsonResponse
     */
    public function update(Request $request, Unity $unity)
    {
        $unity->update($request->validated());

        return response()->json([
            'data' => $unity,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Unity  $unity
     * @return JsonResponse
     */
    public function destroy(Unity $unity)
    {
        $unity->delete();

        return response()->json([
            'message' => 'Unity deleted successfully',
        ]);
    }
}
