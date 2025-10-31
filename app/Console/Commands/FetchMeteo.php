<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Meteo;

class FetchMeteo extends Command
{
    protected $signature = 'meteo:fetch';
    protected $description = 'Récupérer et enregistrer les données météo depuis OpenWeather';

    public function handle()
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => 'Kaolack',
            'appid' => '91d3203e7056d34a0961ebb5333a608d', // Remplace par ta vraie clé API
            'appid' => config('services.openweather.key'),
            'units' => 'metric',
            'lang' => 'fr'
        ]);

        $data = $response->json();

        Meteo::create([
            'ville' => $data['name'],
            'temperature' => $data['main']['temp'],
            'description' => $data['weather'][0]['description'],
            'vitesse_vent' => $data['wind']['speed'],
            'direction_vent' => $data['wind']['deg'] ?? null,
            'humidite' => $data['main']['humidity'],
            'pression' => $data['main']['pressure'],
            'heure' => now()->format('H:i:s'),
        ]);

        $this->info('Données météo récupérées et enregistrées avec succès.');
    }

}
