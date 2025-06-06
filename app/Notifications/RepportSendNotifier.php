<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RepportSendNotifier extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $message;
    public function __construct($message)
    {
        //
        $this->message= $message;
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
                    ->replyTo('dkikimba@virunga.org')
                    ->greeting($this->message['greeting'] ?? "Bonjour")
                    ->line($this->message['title'])
                    // ->action('Acceder a notre site', url(Config('app.url')))
                    ->line('Thank you for using our application!')
                    ->attach($this->message['data']);
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
