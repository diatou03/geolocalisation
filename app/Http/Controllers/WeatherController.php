<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    /**
     * Affiche la météo pour une ville donnée
     */
    public function show(Request $request)
    {
        // Ville par défaut
        $city = $request->get('city', 'Dakar');

        // Récupération de la clé API dans le .env
        $apiKey = env('OPENWEATHER_API_KEY');

        if (empty($apiKey)) {
            Log::error('Clé OpenWeather manquante dans .env');
            return back()->with('error', 'Clé API manquante. Vérifie ton fichier .env');
        }

        try {
            // Appel à l'API OpenWeather
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $city,
                'units' => 'metric',
                'lang' => 'fr',
                'appid' => $apiKey,
            ]);

            // Si la réponse est une erreur HTTP
            if ($response->failed()) {
                $errorCode = $response->status();
                $errorMsg = $response->json('message') ?? 'Erreur inconnue';
                Log::error("Erreur OpenWeather ($errorCode): $errorMsg");

                return view('welcome', [
                    'city' => ucfirst($city),
                    'weather' => [],
                    'error' => "Impossible de récupérer les données météo : $errorMsg",
                ]);
            }

            // Récupération des données météo
            $weatherData = $response->json();

            // Coordonnées pour la carte
            $lat = $weatherData['coord']['lat'] ?? 14.6928;
            $lon = $weatherData['coord']['lon'] ?? -17.4467;

            // Récupération (optionnelle) des données de marées
            $tideData = $this->getTideData($lat, $lon);

            return view('welcome', [
                'city' => ucfirst($city),
                'weather' => $weatherData,
                'lat' => $lat,
                'lon' => $lon,
                'tideData' => $tideData,
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur API OpenWeather : ' . $e->getMessage());
            return view('welcome', [
                'city' => ucfirst($city),
                'weather' => [],
                'error' => 'Erreur lors de la récupération des données météo.',
            ]);
        }
    }

    /**
     * Exemple simple de récupération de données de marées (facultatif)
     */
    private function getTideData($lat, $lon)
    {
        try {
            $apiKey = env('SERVICES_WORLDTIDES_KEY'); // si tu utilises worldtides
            if (!$apiKey) {
                return [];
            }

            $response = Http::get('https://www.worldtides.info/api/v3', [
                'heights' => '',
                'lat' => $lat,
                'lon' => $lon,
                'key' => $apiKey,
            ]);

            if ($response->failed()) {
                return [];
            }

            return $response->json()['heights'] ?? [];
        } catch (\Exception $e) {
            Log::error('Erreur récupération marées : ' . $e->getMessage());
            return [];
        }
    }
}
