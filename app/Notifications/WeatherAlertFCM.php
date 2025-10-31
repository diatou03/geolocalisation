<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use Kreait\Laravel\Firebase\Facades\FirebaseMessaging;

class WeatherAlertFCM extends Notification
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['fcm'];
    }

    public function toFcm($notifiable)
    {
        $notification = FirebaseNotification::create('Alerte météo', $this->message);

        $message = CloudMessage::withTarget('token', $notifiable->fcm_token)
            ->withNotification($notification);

        FirebaseMessaging::send($message);
    }
}
