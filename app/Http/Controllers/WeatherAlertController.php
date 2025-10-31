<?php

namespace App\Http\Controllers;

use App\Models\WeatherAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\Messaging;

class WeatherAlertController extends Controller
{
    public function send(Request $request)
    {
        $regions = [
            'Dakar', 'Saint-Louis', 'Ziguinchor', 'Diourbel',
            'Kaolack', 'Thiès', 'Louga', 'Fatick',
            'Kolda', 'Matam', 'Kaffrine', 'Kédougou',
            'Sédhiou', 'Tambacounda',
        ];

        $apiKey = env('OPENWEATHER_API_KEY');
        $tideToken = env('QWEATHER_API_KEY');
        $date = now()->format('Y-m-d');

        $messaging = app(Messaging::class);

        foreach ($regions as $regionName) {
            // Géocodage
            $geo = Http::get('http://api.openweathermap.org/geo/1.0/direct', [
                'q'     => $regionName . ', SN',
                'limit' => 1,
                'appid' => $apiKey
            ])->json();

            if (!isset($geo[0]['lat'], $geo[0]['lon'])) {
                continue;
            }

            $lat = $geo[0]['lat'];
            $lon = $geo[0]['lon'];

            // Météo actuelle
            $weather = Http::get('https://api.openweathermap.org/data/2.5/onecall', [
                'lat'    => $lat,
                'lon'    => $lon,
                'appid'  => $apiKey,
                'units'  => 'metric',
                'exclude'=> 'minutely,hourly,daily',
            ])->json();

            $alertMsg = "Région : $regionName\n";

            $wind = $weather['current']['wind_speed'] ?? 0;
            $rain = $weather['current']['rain']['1h'] ?? 0;
            $condition = strtolower($weather['current']['weather'][0]['main'] ?? '');

            if ($wind >= 17.2) $alertMsg .= "- Vent très fort ({$wind} m/s)\n";
            if ($rain >= 10) $alertMsg .= "- Pluie intense ({$rain} mm/h)\n";
            if ($condition === 'thunderstorm') $alertMsg .= "- Orage en cours\n";

            if (!empty($weather['alerts'])) {
                foreach ($weather['alerts'] as $alert) {
                    $alertMsg .= "- Alerte officielle : {$alert['event']} — {$alert['description']}\n";
                }
            }

            // Marée
            $tide = Http::get('https://api.qweather.com/v7/ocean/tide', [
                'location' => 'P2951', // ID station spécifique
                'date'     => $date,
                'key'      => $tideToken
            ])->json();

            if (!empty($tide['tideTable'])) {
                foreach ($tide['tideTable'] as $t) {
                    $type = $t['type'] === 'H' ? 'Haute marée' : 'Basse marée';
                    $alertMsg .= "- {$type} à {$t['fxTime']} : {$t['height']} m\n";
                }
            }

            // Envoi notification si alerte existante
            if (trim($alertMsg) !== "Région : $regionName") {
                $notification = Notification::create('Alerte météo', $alertMsg);

                $message = CloudMessage::withTarget('topic', 'all_users')
                    ->withNotification($notification);

                $messaging->send($message);

                // Optionnel : sauvegarder l'alerte en base
                WeatherAlert::create(['message' => $alertMsg]);
            }
        }

        return response()->json(['status' => 'Notifications envoyées avec succès']);
    }

    public function index()
    {
        $alerts = WeatherAlert::orderBy('created_at', 'desc')->get();
        return view('alertes.index', compact('alerts'));
    }

    public function store(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        WeatherAlert::create(['message' => $request->message]);
        return redirect()->route('alertes.index')->with('success', 'Alerte ajoutée avec succès !');
    }
}
