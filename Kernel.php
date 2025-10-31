<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use OpenWeather; // Assurez-vous que le facade est correctement importé
use OneSignal;   // Selon le package que vous utilisez
use App\Services\TideService; // ou autre service responsable de fetchLatestTide

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // 1. Récupérer la météo
            $weather = OpenWeather::getCurrentWeatherByCityName('Kaolack', 'metric');
            $windSpeed = $weather->getCurrently()->getWindSpeed();

            if ($windSpeed > 15) {
                OneSignal::sendNotificationToAll(
                    "🌬️ Alerte vent fort — vitesse : {$windSpeed} m/s"
                );
            }

            // 2. Récupérer la dernière marée via un service dédié
            $tide = app(TideService::class)->fetchLatestTide('Kaolack');

            if ($tide && $tide->height > 3.0) {
                OneSignal::sendNotificationToAll(
                    "🌊 Alerte marée haute — hauteur : " . number_format($tide->height, 2) . " m"
                );
            }

        })->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
    }
}
