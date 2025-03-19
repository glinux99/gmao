<?php

namespace App\Notifications;

use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaintenanceReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $maintenance;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @param Maintenance $maintenance
     * @param User $user
     */
    public function __construct(Maintenance $maintenance, User $user)
    {
        $this->maintenance = $maintenance;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Rappel de Maintenance')
            ->line('Vous avez une maintenance prévue la semaine prochaine.')
            ->line('Description : ' . $this->maintenance->description)
            ->line('Equipement : ' . ($this->maintenance->equipment->name ?? 'N/A'))
            ->line('Date de début : ' . $this->maintenance->start_date)
            ->line('Date de fin : ' . $this->maintenance->end_date)
            ->action('Consulter la maintenance', url('/maintenances/' . $this->maintenance->id))
            ->line('Merci de votre attention!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

