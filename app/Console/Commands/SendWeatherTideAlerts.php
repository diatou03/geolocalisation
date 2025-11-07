<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WeatherAlertController;

class SendWeatherTideAlerts extends Command
{
    // Nom de la commande artisan
    protected $signature = 'alerts:send-weather-tide';

    // Description
    protected $description = 'Envoie automatiquement des alertes météo et marée';

    public function handle()
    {
        $controller = app(WeatherAlertController::class);

        $weather = $controller->fetchWeatherData(); // récupère les données météo
        $tide    = $controller->fetchTideData();    // récupère les données marée

        // Vérifie les conditions pour envoyer une alerte
        if ($weather['wind'] >= 17.2 || $weather['rain'] >= 10 || $tide['high'] >= 2.0) {
            $controller->sendAlerts();  // méthode qui envoie les notifications FCM ou email
            $this->info('✅ Alerte météo/marée envoyée.');
        } else {
            $this->info('ℹ️ Conditions normales, aucune alerte.');
        }
    }
}
