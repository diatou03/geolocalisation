<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->query('city', 'Dakar');
        $type = $request->query('type', 'current'); // 🔹 "current" ou "forecast"

        $weather = null;
        $lat = $lon = null;

        try {
            $apiKey = env('OPENWEATHER_API_KEY');

            // 🔹 Étape 1 : géocoder la ville
            $geo = Http::get("https://api.openweathermap.org/geo/1.0/direct", [
                'q' => $city,
                'limit' => 1,
                'appid' => $apiKey,
            ])->json();

            if (empty($geo)) {
                return back()->with('error', 'Ville non trouvée.');
            }

            $lat = $geo[0]['lat'];
            $lon = $geo[0]['lon'];

            // 🔹 Étape 2 : météo actuelle OU prévisions
            if ($type === 'forecast') {
                // Prévisions météo (toutes les 3h sur 5 jours)
                $response = Http::get('https://api.openweathermap.org/data/2.5/forecast', [
                    'lat' => $lat,
                    'lon' => $lon,
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'fr',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    // On prend les prévisions pour les 3 prochains jours (24 points = 3 jours)
                    $weather = ['list' => array_slice($data['list'], 0, 24)];
                }
            } else {
                // Météo actuelle
                $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                    'lat' => $lat,
                    'lon' => $lon,
                    'appid' => $apiKey,
                    'units' => 'metric',
                    'lang' => 'fr',
                ]);

                if ($response->successful()) {
                    $weather = $response->json();
                }
            }
        } catch (\Exception $e) {
            $weather = null;
        }

        // 🔹 Marées
        $communeForTides = null;
        $regions = config('tides.locations') ?? [];

        if (is_array($regions) && !empty($regions)) {
            foreach ($regions as $regionKey => $region) {
                if (!isset($region['communes']) || !is_array($region['communes'])) continue;

                foreach ($region['communes'] as $communeKey => $commune) {
                    if (strtolower($commune['name']) === strtolower($city)) {
                        $communeForTides = ['region' => $regionKey, 'commune' => $communeKey];
                        break 2;
                    }
                }
            }
        }

        return view('welcome', [
            'city' => $city,
            'weather' => $weather,
            'lat' => $lat,
            'lon' => $lon,
            'type' => $type,
            'tidesRegion' => $communeForTides['region'] ?? null,
            'tidesCommune' => $communeForTides['commune'] ?? null,
        ]);
    }

    public function weather(Request $request)
    {
        return $this->index($request);
    }
}
