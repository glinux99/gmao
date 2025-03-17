<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCategoryRequest;
use Symfony\Component\HttpFoundation\Response;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('unity')->get();
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
        $category = Category::create($request->validated());

        return response()->json([
            'data' => $category,
            'message' => 'Category created successfully',
            'success' => true
        ], Response::HTTP_CREATED);
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
}
