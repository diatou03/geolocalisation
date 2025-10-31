<?php

namespace App\Http\Controllers;

use App\Models\Meteo;
use App\Models\Localisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // ✅ Import nécessaire
class MeteoController extends Controller
{
   

public function showWeather(Request $request)
{
    $city = $request->input('city'); // Ex: Kaolack
    $weather = null;
    $error = null;

    if ($city) {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q'     => $city,
            'appid' => config('services.openweather.key'), // clé dans .env
            'units' => 'metric',
            'lang'  => 'fr',
        ]);

        if ($response->successful()) {
            $weather = $response->json();
        } else {
            $error = "Ville introuvable ou erreur API.";
        }
    }

    return view('meteo.weather', compact('weather', 'error', 'city'));
}
 public function index()
    {
        // Récupère toutes les données météo
        $meteo = Meteo::with('ville')->get(); // si tu as une relation 'ville'

        // Retourne la vue en passant la variable $meteo
        return view('meteo.index', compact('meteo'));
    }
}
