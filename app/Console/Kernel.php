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
                 ->between('6:00', '20:00')
                 ->weekdays()
                 ->withoutOverlapping()
                 ->onSuccess(fn () => logger()->info('✅ Alerte envoyée par scheduler'))
                 ->onFailure(fn () => logger()->error('❌ Échec envoi alerte scheduler'));
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
