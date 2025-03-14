<?php

namespace App\Http\Controllers;

use App\Models\EmailRepport;
use Illuminate\Http\Request;

class EmailRepportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "dkikimba@virunga.org";
    }
    public function password(){
        return "ysejwahgeorrtnbv";
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
    public function show(EmailRepport $emailRepport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailRepport $emailRepport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailRepport $emailRepport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailRepport $emailRepport)
    {
        //
    }
}
