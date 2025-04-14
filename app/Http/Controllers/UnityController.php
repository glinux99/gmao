<?php

namespace App\Http\Controllers;

use App\Models\Unity;
use Carbon\Unit;
use Illuminate\Http\Request;

class UnityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unities= Unity::all();
        $title = 'Supprimer cette unité!';
        $text = "Voulez-vous supprimer cette unité?";
        confirmDelete($title, $text);
        return view('unities.unities', ['unities'=>$unities]);
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
        Unity::create($request->all());
        toast('L\'ajout de l\'unite '.$request->designation.' s\'est effectue avec success','success');
        return redirect()->route('unities.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unity $unity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unity $unity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unity $unity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unity $unity)
    {
        try {
            $unity->delete();
            toast('L\'unité '.$unity->designation.' a été supprimé avec succèss','success');
            return redirect()->route('unities.index');
        } catch (\Throwable $th) {
            //throw $th;
            toast('L\'unité '.$unity->designation.' n\'a pas été supprimé car elle est utilisé','error');
            return redirect()->route('unities.index');
        }

    }
}
