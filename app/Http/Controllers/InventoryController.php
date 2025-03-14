<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\StockHistory;
use App\Models\User;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sorties=StockHistory::with(['category'])
            ->orderByDesc("id")
            ->get()->unique('category_id');
        $technicians= User::where('type', 'technician')->get();
        $categories = Category::all();
        return view('inventories.inventories',['sorties'=>$sorties, 'technicians'=>$technicians, 'categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockHistory $stockHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockHistory $stockHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockHistory $stockHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockHistory $stockHistory)
    {
        //
    }
}
