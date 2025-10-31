<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Liste des commandes Artisan fournies par l'application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SendWeatherTideAlerts::class,
    ];

    /**
     * Définit le programme des tâches planifiées (Scheduler).
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
   protected function schedule(Schedule $schedule): void
{
    $schedule->command('alerts:send-weather-tide')
        ->hourly()
        ->between('6:00', '20:00')     // Ne s'exécute qu'entre 6h et 20h
        ->weekdays()                   // Et uniquement en semaine
        ->when(function () {
            // Logique conditionnelle : retourne true si on veut envoyer une alerte
            $weather = app(\App\Http\Controllers\WeatherAlertController::class)
                        ->fetchWeatherData(); // méthode à créer
            $tide    = app('App\Http\Controllers\WeatherAlertController')
                        ->fetchTideData();    // idem

            // Vérifier les conditions selon ton contrôle météo/marée
            if ($weather['wind'] >= 17.2 || $weather['rain'] >= 10 || $tide['high'] >= 2.0) {
                return true;
            }
            return false;
        })
        ->withoutOverlapping()
        ->onSuccess(fn () => logger()->info('Alerte météo/marée envoyée automatiquement.'))
        ->onFailure(fn () => logger()->error('Échec envoi alerte auto.'));
}

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * (Optionnel) Définit le fuseau horaire par défaut pour le scheduler.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone(): string|\DateTimeZone|null
    {
        return 'Africa/Dakar';
    }
    public function fetchWeatherData()
{
    // Appel API OpenWeather, traitement des infos météo
}

public function fetchTideData()
{
    // Appel API marée (QWeather ou Stormglass), récupération du niveau
}

}
