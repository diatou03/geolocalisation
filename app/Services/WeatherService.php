<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherAlertController extends Controller
{
    public function index()
    {
        $city = 'Dakar'; // ✅ Valeur par défaut
        $lat = 14.6928;
        $lon = -17.4467;

        $weather = [];
        $tideData = [];

        try {
            // 🌦️ Récupération des données météo
            $apiKey = env('OPENWEATHER_API_KEY');
            $weatherResponse = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'units' => 'metric',
                'lang' => 'fr',
                'appid' => $apiKey,
            ]);

            if ($weatherResponse->successful()) {
                $weather = $weatherResponse->json();
            } else {
                $weather = ['error' => 'Impossible de récupérer les données météo.'];
            }

            // 🌊 Récupération des marées (WorldTides API)
            $tideKey = env('WORLDTIDES_API_KEY');
            $tideResponse = Http::get("https://www.worldtides.info/api/v2", [
                'extremes' => '',
                'lat' => $lat,
                'lon' => $lon,
                'key' => $tideKey,
            ]);

            if ($tideResponse->successful()) {
                $tideData = $tideResponse->json()['extremes'] ?? [];
            } else {
                $tideData = [];
            }

        } catch (\Exception $e) {
            $weather = ['error' => $e->getMessage()];
            $tideData = [];
        }

        // ✅ Envoi des variables à la vue
        return view('welcome', compact('city', 'lat', 'lon', 'weather', 'tideData'));
    }
}
