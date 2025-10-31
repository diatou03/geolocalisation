<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlerteParEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
    
     public function toMail($notifiable) {
        return (new MailMessage)
            ->subject("⚠️ Alerte Pirogue : {$this->alerte->type}")
            ->line("Alerte sur la pirogue {$this->alerte->pirogue->nom}")
            ->line($this->alerte->message)
            ->action('Voir l’alerte', url("/alertes/{$this->alerte->id}"))
            ->line('Soyez prudents en mer.');
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
