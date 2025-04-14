<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionApiController extends Controller
{
    /**
     * Display a listing of the regions.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $regions = Region::all();

        return response()->json(['data' => $regions]);
    }

    /**
     * Store a newly created region in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        // return 123;
       try {
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $region = Region::create($request->all());

        return response()->json(['data' => $region], 201);
       } catch (\Throwable $th) {
        //throw $th;
        return response()->json(['errors' => $th], 422);
       }
    }

    /**
     * Display the specified region.
     *
     * @param Region $region
     * @return JsonResponse
     */
    public function show(Region $region): JsonResponse
    {
        return response()->json(['data' => $region]);
    }

    /**
     * Update the specified region in storage.
     *
     * @param Request $request
     * @param Region $region
     * @return JsonResponse
     */
    public function update(Request $request, Region $region): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $region->update($request->all());

        return response()->json(['data' => $region]);
    }

    /**
     * Remove the specified region from storage.
     *
     * @param Region $region
     * @return JsonResponse
     */
    public function destroy(Region $region): JsonResponse
    {
        $region->delete();

        return response()->json(null, 204);
    }
}
