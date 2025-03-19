<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    public $message;
    public $task;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @param Task $task The task being assigned.
     * @param Task $user The task being assigned.
     * @param array $message Optional message data for the email.
     */
    public function __construct(Task $task, User $user, array $message = [])
    {
        $this->task = $task;
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail']; // We're only sending an email
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->replyTo('dkikimba@virunga.org')
                    ->greeting($this->message['greeting']?? 'Bonjour'.' '.$this->user->name.' '.$this->user->post_name.' '.$this->user->nickname  )
                    ->line($this->message['title'] ?? 'Une nouvelle tâche vous a été attribuée !')
                    ->line('Description : ' . $this->task->description)
                    ->line('Priorité : ' . $this->task->priority->title)
                    ->line('Status : ' . $this->task->status)
                    ->line('Date de début : ' . $this->task->start_date)
                    ->line('Date de fin : ' . $this->task->due_date)
                    ->action('Voir la tâche', url("tasks/".$this->task->id))
                    ->line('Merci!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            // You can still return task data here if you need it for other channels
            'task_id' => $this->task->id,
             'task_description' => $this->task->description,
            'task_priority' => $this->task->priority->title,
            'task_status' => $this->task->status,
            'task_start_date' => $this->task->start_date,
            'task_due_date' => $this->task->due_date,
            'message'=> 'Une nouvelle tâche vous a été attribuée !'

        ];
    }
}
