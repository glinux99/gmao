<?php

namespace App\Console\Commands;

use App\Models\Maintenance;
use App\Notifications\MaintenanceReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CheckMaintenanceSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:check-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check maintenance schedule and send reminders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("CheckMaintenanceSchedule command started");
        // Calculate the date one week from now
        $oneWeekFromNow = Carbon::now()->addWeek();

        // Retrieve maintenances starting within one week
        $maintenances = Maintenance::whereDate('start_date', '<=', $oneWeekFromNow)
            ->whereDate('start_date', '>', Carbon::now())
            ->get();

        // Loop through the maintenances and send notifications
        foreach ($maintenances as $maintenance) {
            Log::info("Processing maintenance ID: " . $maintenance->id);
            // Get the responsible user (assigned user)
            $responsibleUser = $maintenance->assigned_user;

            // Get the owner of the maintenance
            $owner = $maintenance->user;
            //get all techniciens
            $technicians=$maintenance->technicians;


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
                    Log::info("Sending notification to: " . $user->email);
                    $user->notify(new MaintenanceReminderNotification($maintenance, $user));
                }else{
                    Log::error('user not found : ',$email);
                }
            }
            // Update notified_at column to avoid multiple sending notification
            $maintenance->notified_at = Carbon::now();
            $maintenance->save();
        }

        Log::info("CheckMaintenanceSchedule command finished");
    }
}
