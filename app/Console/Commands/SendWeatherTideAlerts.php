<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WeatherAlertController;

class SendWeatherTideAlerts extends Command
{
    protected $signature = 'alerts:send-weather-tide';
    protected $description = 'Envoi automatique des alertes météo et marées';

    public function handle()
    {
        (new WeatherAlertController)->send();
        $this->info('Alertes météo et marées envoyées.');
    }
}
