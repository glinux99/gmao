<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MaintenanceMaterial;
use Illuminate\Http\Request;
use App\Imports\ImportCategory;
use App\Models\Maintenance;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('unity')->orderBy('id', 'DESC')->get();
        return response()->json([
            'data' => $categories,
            'message' => 'Categories fetched successfully',
            'success' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'designation' => 'required|string|max:255',
            'caracteristique' => 'nullable|string|max:255',
            'unity_id' => 'nullable|exists:unities,id',
            'type' => 'nullable|string|max:255',
            'is_remise' => 'nullable|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for avatar
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            DB::beginTransaction();

            $data = $request->all();

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = 'storage/' . $avatarPath;
            }

            // Set is_remise to false if not provided
            $data['is_remise'] = $request->input('is_remise', false);

            $category = Category::create($data);

            // $this->handleDuplicates();

            DB::commit();

            return response()->json([
                'data' => $category,
                'message' => 'Category created successfully',
                'success' => true
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['errors' => $th->getMessage(), 'success' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
     /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'designation' => 'sometimes|required|string|max:255',
            'caracteristique' => 'nullable|string|max:255',
            'unity_id' => 'nullable|exists:unities,id',
            'type' => 'nullable|string|max:255',
            'is_remise' => 'nullable|boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for avatar
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            DB::beginTransaction();

            $data = $request->except('avatar');

            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($category->avatar) {
                    Storage::delete(str_replace('storage/', 'public/', $category->avatar));
                }
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = 'storage/' . $avatarPath;
            }

            $category->update($data);

            // $this->handleDuplicates();

            DB::commit();

            return response()->json([
                'data' => $category,
                'message' => 'Category updated successfully',
                'success' => true
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['errors' => $th->getMessage(), 'success' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    protected function handleDuplicates()
    {
        try {
            // return 123;
            // Get all categories that are linked to maintenances
            $categoriesInMaintenances = Maintenance ::with(['equipment','tasks', 'user','expenses', 'materials' => function ($query) {
                $query->select('categories.*', 'maintenance_material.quantity');
            }, 'instructions', 'region']);


            return $categoriesInMaintenances;
            // Get all categories that are linked to tasks
            $categoriesInTasks = Task::with('materials')
                ->get()
                ->flatMap(function ($task) {
                    return $task->materials;
                })
                ->unique()
                ->values();

            // Merge the two collections and remove duplicates
            $allCategories = $categoriesInMaintenances->merge($categoriesInTasks)->unique()->values();

            // Return the result
            return response()->json([
                'data' => $allCategories,
                'message' => 'Categories in maintenances and tasks fetched successfully',
                'success' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage(), 'success' => false], 500);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json([
            'data' => $category->load('unity'),
            'message' => 'Category fetched successfully',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            // Delete old avatar if exists
            if ($category->avatar) {
                Storage::delete(str_replace('storage/', 'public/', $category->avatar));
            }

            $category->delete();

            return response()->json([
                'data' => null,
                'message' => 'Category deleted successfully',
                'success' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json(['errors' => $th->getMessage(), 'success' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'success' => false], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            Excel::import(new ImportCategory, $request->file('file'));
            return response()->json([
                'message' => 'Categories imported successfully',
                'success' => true
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Row " . $failure->row() . ": " . implode(", ", $failure->errors());
            }
            return response()->json([
                'errors' => $errors,
                'message' => 'Validation error',
                'success' => false
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during import.',
                'success' => false
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handles duplicate categories.
     *
     * @param Category $category
     * @return void
     */

}
