<?php

namespace App\Http\Controllers;

use App\Mail\TaskAssigned;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TaskApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks= Task::with(['project', 'owner', 'user'])->get();
        return response(['data'=>$tasks]);
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

        $task=Task::create($request->all());
        $user = User::find($task->user_id);

        if($user){
            // Send email notification
        //    Mail::to($user->email)->send(new TaskAssigned($task, $user));
            // Send an email via a notification
            $user->notify(new TaskAssignedNotification($task,$user, [
            ]));
       }
        return response(['data'=>$task]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $task)
    {
        try {
        $task= Task::find($task);
        $user = User::find($task->user_id);
        $request['owner']=$request->owner->id ?? null;
        $task->update($request->all());
        if($user){
           Mail::to($user->email)->send(new TaskAssigned($task, $user));
        }
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
        return response()->json(['data'=> $task]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
