<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamUser;
use Illuminate\Http\Request;

class TeamApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       try {
        $teams = Team::with('user','users')->get();
       } catch (\Throwable $th) {
        //throw $th;
        return $th->getMessage();
       }
        return response()->json(['data' => $teams]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'user_id' => 'required|exists:users,id',
            ]);
            $team = Team::create($request->all());
            foreach ($request->members as $value) {
                # code...
                TeamUser::create(['user_id'=>$value, 'team_id'=>$team->id]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
        return response()->json(['data' => $team], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'user_id' => 'required|exists:users,id',
        // ]);
       try {
        $team->update($request->all());
        if(isset($request->members)){
            $team->users()->sync($request->members);
        }
       } catch (\Throwable $th) {
        //throw $th;
        return $th->getMessage();
       }
        return response()->json(['data' => $team]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        //
    }
}
