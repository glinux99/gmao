<?php

namespace App\Http\Controllers;

use App\Imports\GoogleMapsImport;
use App\Models\GoogleMaps;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GoogleApiController extends Controller
{
    public function index(){

        $maps = GoogleMaps::all();
        return response()->json(['data'=>$maps]);
    }
    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        $maps = GoogleMaps::all();
        foreach($maps as $map){
            $map->delete();
        }
        Excel ::import(new GoogleMapsImport , $request->file('file'));
        $maps = GoogleMaps::all();
        return response()->json(['data'=> $maps]);
    }
}
