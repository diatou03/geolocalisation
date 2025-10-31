<?php

namespace App\Notifications;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlertePirogueNotification extends Notification
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
        return [TwilioChannel::class];
    }
    

    /**
     * Get the mail representation of the notification.
     */
   public function toTwilio($notifiable)
{
    return (new TwilioSmsMessage())
        ->content("⚠️ Alerte sur la pirogue {$this->alerte->pirogue->nom} : {$this->alerte->message}")
        ->from(config('services.twilio.from'));
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
    protected static function booted()
    {
    static::created(function ($alerte) {
        $alerte->pirogue->notify(new AlertePirogueNotification($alerte));
    });
    }
    
}
