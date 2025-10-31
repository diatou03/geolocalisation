<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->query('city', 'Dakar');

        $weather = null;
        $lat = $lon = null;

        try {
            $apiKey = env('OPENWEATHER_API_KEY');
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => env('OPENWEATHER_API_LANG', 'fr'),
            ]);
            if ($response->successful()) {
                $weather = $response->json();
                $lat = $weather['coord']['lat'] ?? 14.6928;
                $lon = $weather['coord']['lon'] ?? -17.4467;
            }
        } catch (\Exception $e) {
            $weather = null;
        }

        // On redirige automatiquement vers la page marées de la commune si la ville correspond
        $communeForTides = null;
       $regions = config('tides.locations') ?? [];

        if (!is_array($regions) || empty($regions)) {
         return back()->with('error', 'Impossible de charger les régions de marées.');
        }

          foreach ($regions as $regionKey => $region) {
          if (!isset($region['communes']) || !is_array($region['communes'])) continue;

          foreach ($region['communes'] as $communeKey => $commune) {
          if (strtolower($commune['name']) === strtolower($city)) {
            $communeForTides = ['region' => $regionKey, 'commune' => $communeKey];
            break 2;
        }
   }
}
        return view('welcome', [
            'city' => $city,
            'weather' => $weather,
            'lat' => $lat,
            'lon' => $lon,
            'tidesRegion' => $communeForTides['region'] ?? null,
            'tidesCommune' => $communeForTides['commune'] ?? null,
        ]);
    }

    public function weather(Request $request)
    {
        return $this->index($request);
    }
}
