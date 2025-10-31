<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class HomeController extends Controller
{
    // Page d'accueil publique (météo + marées)
    public function welcome()
    {
        $city = 'Dakar';
        $openWeatherKey = env('OPENWEATHER_API_KEY');
        $worldTidesKey  = env('SERVICES_WORLDTIDES_KEY');

        // 🌤️ MÉTÉO
        $weather = $this->getWeather($city, $openWeatherKey);

        // 🌊 MARÉES
        $tides = $this->getTides($worldTidesKey);

        return view('welcome', compact('weather', 'tides'));
    }

    private function getWeather($city, $apiKey)
    {
        try {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'fr',
            ]);

            if ($response->failed()) return ['error' => 'Impossible de récupérer la météo.'];

            $data = $response->json();

            return [
                'city' => $city,
                'temp' => $data['main']['temp'] ?? '-',
                'humidity' => $data['main']['humidity'] ?? '-',
                'wind' => $data['wind']['speed'] ?? '-',
                'description' => ucfirst($data['weather'][0]['description'] ?? 'N/A'),
                'timestamp' => Carbon::now()->format('d/m/Y H:i')
            ];
        } catch (\Exception $e) {
            return ['error' => "Erreur météo : " . $e->getMessage()];
        }
    }

    private function getTides($apiKey)
    {
        try {
            $latitude = 14.6928;
            $longitude = -17.4467;

            $response = Http::get('https://www.worldtides.info/api/v3', [
                'extremes' => '',
                'lat' => $latitude,
                'lon' => $longitude,
                'key' => $apiKey,
                'length' => 48,
            ]);

            if ($response->failed()) return ['error' => 'Impossible de récupérer les marées.'];

            $data = $response->json();
            if (!isset($data['extremes'])) return ['error' => 'Aucune donnée de marées disponible.'];

            return collect($data['extremes'])->map(function ($tide) {
                return [
                    'date' => Carbon::parse($tide['date'])->format('d/m H:i'),
                    'type' => ucfirst($tide['type']),
                    'height' => number_format($tide['height'], 2),
                ];
            })->toArray();

        } catch (\Exception $e) {
            return ['error' => "Erreur marées : " . $e->getMessage()];
        }
    }
}
