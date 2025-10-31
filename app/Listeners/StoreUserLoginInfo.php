<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LoginLog;
use Illuminate\Support\Facades\Request;
use GeoIP;
class StoreUserLoginInfo
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
        public function handle(Login $event)
    {
        $user = $event->user;
        $ip = Request::ip();

        // Localisation via GeoIP
        $location = geoip()->getLocation($ip);

        LoginLog::create([
            'user_id' => $user->id,
            'ip' => $ip,
            'city' => $location->city,
            'country' => $location->country,
            'latitude' => $location->lat,
            'longitude' => $location->lon,
        ]);
    }

}
