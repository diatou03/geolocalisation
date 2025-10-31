<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Meteo;

class SauvegarderMeteo extends Command
{
    protected $signature = 'meteo:sauvegarder';
    protected $description = 'Récupère et enregistre les données météo depuis une API';

    public function handle()
    {
        $ville = 'Kaolock';
        $apiKey = '91d3203e7056d34a0961ebb5333a608d';

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $ville,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'fr',
        ]);

        if ($response->successful()) {
            $data = $response->json();

            Meteo::create([
                'ville' => $data['nom'],
                'temperature' => $data['main']['temp'],
                'description' => $data['weather'][0]['description'],
                'vitesse_vent' => $data['wind']['speed'],
                'direction_vent' => $data['wind']['deg'],
                'humidite' => $data['main']['humidity'],
                'heure_prévision' => now()->format('H:i:s'),
            ]);

            $this->info('Météo enregistrée avec succès.');
        } else {
            $this->error('Erreur lors de la récupération des données météo.');
        }
    }
}
