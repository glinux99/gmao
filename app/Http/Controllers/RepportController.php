<?php

namespace App\Http\Controllers;

use App\Models\Repport;
use Illuminate\Http\Request;

class RepportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('repports.repports');
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
    public function show( $repport)
    {
        return view('repports.repportDetails');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $repport)
    {
        return view('repports.repportDetails');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Repport $repport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repport $repport)
    {
        //
    }
}
