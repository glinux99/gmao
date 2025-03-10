<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\UserRepport;
use Illuminate\Http\Request;

class UserRepportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repports=UserRepport::all();
        $category=Category::all();
        $title = 'Supprimer cette ecoute!';
        $text = "Vous ne voulez plus que cette utilisateur puisse avoir acces au rapport?";
        confirmDelete($title, $text);
        return view('repports.repports',['repports'=>$repports, 'categories'=>$category]);
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
        UserRepport::create($request->all());
        return redirect()->route('repports.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserRepport $userRepport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserRepport $userRepport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserRepport $userRepport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $userRepport)
    {
        // dd($userRepport);
        // $userRepport->delete();
        UserRepport::find($userRepport)->delete();
        toast(title:"L'ecouteur du rapport a ete supprime avec succes", type:"success");
        return redirect()->route("repports.index");
    }
}
