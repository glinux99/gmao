<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskApiController extends Controller
{
    public function index()
    {
        $tasks=[];
      try {
        $userAuht=Auth::id();
        if(User::find( $userAuht)->hasExactRoles(['technicien'])){
            $teams = TeamUser::where('user_id',  $userAuht)->get();
            $teamId=[];
            foreach($teams as $team){
                $teamId[]=$team->team_id;
            }
            if($teamId){
                $tasks = Task::with('project', 'instructions', 'assigned_team', 'assigned_user', 'owner_user', 'priority')->where('user_id', Auth::user()->id)->OrWhere('assigned_user_id', Auth::user()->id)->orWhereIn('assigned_team_id', $teamId)->orderByDesc('id')->get();
            }else
                {
                    $tasks = Task::with('project', 'instructions', 'assigned_team', 'assigned_user', 'owner_user', 'priority')->where('assigned_user_id', Auth::user()->id)->orderByDesc('id')->get();

                }
           }else{
            $tasks = Task::with('project', 'instructions', 'assigned_team', 'assigned_user', 'owner_user', 'priority')->orderByDesc('id')->get();
           }
            return response()->json(['data' => $tasks]);
      } catch (\Throwable $th) {
        //throw $th;
        return $th->getMessage();
      }
    }

    public function show(Task $task)
    {
        $task->load('project', 'instructions', 'assigned_team', 'assigned_user', 'owner_user', 'priority');
        return response()->json(['data' => $task]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $request['type']="Task";
        try {
            $taskData = $request->except('instructions');
            $task = Task::create($taskData);

            // Create instructions
            if ($request->has('instructions')) {
                foreach ($request->input('instructions') as $instructionData) {
                    $task->instructions()->create($instructionData);
                }
            }

            // Send notifications after creating the task
           try {
            $this->sendTaskNotifications($task);
           } catch (\Throwable $th) {
            //throw $th;
           }

            DB::commit();
            return response()->json(['data' => $task], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Task $task)
    {

        DB::beginTransaction();
        try {
            $taskData = $request->except('instructions');
            $task->update($taskData);
            // Update or create instructions
            if ($request->has('instructions')) {
                // Delete existing instructions
                $task->instructions()->delete();

                // Create new instructions
                foreach ($request->input('instructions') as $instructionData) {
                    $task->instructions()->create($instructionData);
                }
            }

            // Send notifications after updating the task
            try {
                if($task->status=='paused'){
                    $this->sendTaskNotifications($task);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }

            DB::commit();
            return response()->json(['data' => $task]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }

    protected function sendTaskNotifications(Task $task)
    {
        // Get the responsible user (assigned user)
        $responsibleUser = $task->user;

        // Get the owner of the task
        $owner = User::find($task->owner);

        // Get the team associated with the task
        $team = Team::find($task->assigned_team_id);
        $technicians = [];
        if ($team) {
            $technicians = $team->users;
        }

        // Collect email addresses
        $emails = [];
        if ($responsibleUser) {
            $emails[] = $responsibleUser->email;
        }
        if ($owner) {
            $emails[] = $owner->email;
        }
        foreach ($technicians as $technician) {
            $emails[] = $technician->email;
        }

        // Remove duplicate emails
        $emails = array_unique($emails);

        // Send the notification to each recipient
        foreach ($emails as $email) {
            // Find the user by email
            $user = User::where('email', $email)->first();

            if ($user) {
                try {
                    $user->notify(new TaskAssignedNotification($task, $user, []));
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
    }
}
