<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users= User::where('type', 'technician')->get();
        return view('technicians.technicians',['users'=>$users]);
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
        $user = new UserController;
        $request['role']="technicien";
        $user->store($request);
            return redirect()->route('technicians.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Technician $technician)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('technicians.technician', ['user' => $user]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technician $technician)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $technician)
    {
        //
    }
}
