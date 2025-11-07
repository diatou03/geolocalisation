<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gps;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GpsController extends Controller
{
    // Affiche la vue carte Leaflet
    public function index()
    {
        return view('gps.map'); // Ta vue existante
    }

    // Localisation par IP
    // Localisation par IP
    public function locateByIp(Request $request)
    {
        try {
            // 🌍 Fallback par défaut (Sénégal)
            $default = (object)[
                'country' => 'Sénégal',
                'city'    => 'Dakar',
                'lat'     => 14.7167,
                'lon'     => -17.4677
            ];

            // Mode local / debug
            if (app()->environment('local')) {
                $data = $default;
            } else {
                // Récupérer IP réelle
                $ip = $request->ip();

                // Vérifier si IP privée / locale
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
                    $ip = '8.8.8.8'; // Google DNS pour test public
                }

                // Si derrière proxy
                if ($request->server('HTTP_X_FORWARDED_FOR')) {
                    $xff = explode(',', $request->server('HTTP_X_FORWARDED_FOR'))[0] ?? null;
                    if ($xff && filter_var($xff, FILTER_VALIDATE_IP)) $ip = trim($xff);
                }

                // Appel API ip-api.com
                $json = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,message,country,city,lat,lon");
                $result = json_decode($json);

                if (!$result || $result->status !== 'success') {
                    $data = $default; // fallback si erreur API
                } else {
                    $data = $result;
                }
            }

            // Enregistrer en base (facultatif)
            $recordId = null;
            try {
                $gps = Gps::create([
                    'user_id'   => Auth::id() ?? null,
                    'ip'        => $request->ip(),
                    'country'   => $data->country ?? null,
                    'city'      => $data->city ?? null,
                    'latitude'  => $data->lat ?? null,
                    'longitude' => $data->lon ?? null,
                ]);
                $recordId = $gps->id;
            } catch (\Throwable $e) {
                Log::error('GPS save error: '.$e->getMessage());
            }

            return response()->json([
                'status'    => 'ok',
                'ip'        => $request->ip(),
                'country'   => $data->country ?? null,
                'city'      => $data->city ?? null,
                'latitude'  => $data->lat ?? null,
                'longitude' => $data->lon ?? null,
                'record_id' => $recordId,
            ]);

        } catch (\Throwable $e) {
            Log::error('locateByIp error: '.$e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur serveur'], 500);
        }
    }
    public function showMap()
    {
        return view('gps.map');
    }
}
