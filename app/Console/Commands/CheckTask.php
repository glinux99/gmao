<?php

namespace App\Console\Commands;

use App\Mail\TaskDeadlineExceeded;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class CheckTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get tasks where the due date is in the past AND the status is NOT 'completed'
        $tasks = Task::where('due_date', '<=', Carbon::now())
            ->where('status', '!=', 'completed')
            ->with('user') // Eager load the user relationship
            ->get();

        // Iterate through each task
        foreach ($tasks as $task) {
            $task->status = "delayed";
            $task->save();
            // Check if the user is associated with the task
            if ($task->user) {
                try {
               Mail::to($task->user->email)->send(new TaskDeadlineExceeded($task));
                    
                } catch (\Throwable $th) {
                    //throw $th;
                }
               // Log the notification  
               $this->info("Notification sent for task: {$task->description} (ID: {$task->id}) to {$task->user->email}");
             }else {
                // Log that the notification couldn't be sent
                 $this->error("Notification not sent for task: {$task->description} (ID: {$task->id}). No user associated.");
             }

        }
        $this->info('Task deadline check complete.');
    }
}
