<?php

namespace App\Http\Controllers;

use App\Events\UserLoginProcess;
use App\Imports\GoogleMapsImport;
use App\Models\GoogleMaps;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GoogleMapsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        event(new UserLoginProcess);
        return view('maps.index');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel ::import(new GoogleMapsImport , $request->file('file'));

        return back()->with('success', 'Google Maps imported successfully.');
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
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $maps = GoogleMaps::all();
        foreach($maps as $map){
            $map->delete();
        }
        Excel ::import(new GoogleMapsImport , $request->file('file'));

        dd('success', 'Google Maps imported successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GoogleMaps $GoogleMapss)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GoogleMaps $GoogleMapss)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GoogleMaps $GoogleMapss)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GoogleMaps $GoogleMapss)
    {
        //
    }
}
