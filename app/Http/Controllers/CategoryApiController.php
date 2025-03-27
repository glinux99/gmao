<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCategoryRequest;
use App\Imports\CategoriesImport;
use App\Imports\ImportCategory;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('unity')->orderBy('id', 'DESC')->get();
        return response()->json([
            'data' =>$categories,
            'message' => 'Categories fetched successfully',
            'success' => true
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try {
        $request->validate([
            'designation' => 'required|string|max:255',

        ]);

        $data = $request->all();

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = 'storage/' . $avatarPath;
        }
        if(!isset($request->is_remise)){
            $data['is_remise'] = false;
        }
        $category = Category::create($data);

        return response()->json([
            'data' => $category,
            'message' => 'Category created successfully',
            'success' => true
        ]);
       } catch (\Throwable $th) {
        //throw $th;
        return response()->json(['errors' => $th->getMessage(),'success' => false]);
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
         return response()->json([
            'data' => $category->load('materials'),
            'message' => 'Category fetched successfully',
            'success' => true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json([
            'data' => $category,
            'message' => 'Category updated successfully',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'data' => null,
            'message' => 'Category deleted successfully',
            'success' => true
        ]);
    }
    public function import(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:xlsx,xls',
        // ]);

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
}
