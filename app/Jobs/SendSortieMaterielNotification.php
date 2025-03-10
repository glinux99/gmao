<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendSortieMaterielNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $user;
    public $notification;
    public function __construct($user, $notification)
    {
        //
        $this->user= $user;
        $this->notification= $notification;
    }

    /**
     * Execute the job.
     */
    public function handle( ): void
        {
            // Ici, vous récupérez les données de la notification
            // et envoyez la notification
            $this->user->notify($this->notification);
        }
}
