<?php

namespace App\Listeners;

use App\Events\PanicAlertTriggered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPanicNotifications
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    
    public function handle(PanicAlertTriggered $event)
{
    $alerte = $event->alerte;
    $pirogue = $alerte->pirogue;

    // Email
    $pirogue->notify(new AlerteParEmailNotification($alerte));
    // Slack
    $pirogue->notify(new AlerteSlackNotification($alerte));
}

}
