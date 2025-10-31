<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Gps;

class GpsController extends Controller
{
    /**
     * 🗺️ Affiche la vue contenant la carte GPS
     */
    public function map()
    {
        return view('gps.map'); // resources/views/gps/map.blade.php
    }

    /**
     * 🌍 Géolocalisation d’un utilisateur via son IP et enregistrement
     */
    public function locateByIp(Request $request)
    {
        $ip = $request->getClientIp(); // ou IP fixe pour tester
        try {
            $location = geoip()->getLocation($ip);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Erreur de géolocalisation',
                'error'   => $e->getMessage()
            ], 500);
        }

        // Créer un enregistrement GPS pour la localisation IP
        $gps = Gps::create([
            'device_id'  => 'user_ip',
            'latitude'   => $location->lat,
            'longitude'  => $location->lon,
            'altitude'   => null,
            'speed'      => null,
            'satellites' => null,
            'timestamp'  => now()
        ]);

        return response()->json([
            'status'    => 'ok',
            'ip'        => $location->ip,
            'city'      => $location->city,
            'country'   => $location->country,
            'latitude'  => $location->lat,
            'longitude' => $location->lon,
            'record_id' => $gps->id
        ]);
    }

    /**
     * 🛰️ Réception et enregistrement des données GPS envoyées par ESP32 ou autre IoT
     */
    public function store(Request $request)
    {
        try {
            $dataArray = $request->all();

            if (!is_array($dataArray)) {
                $dataArray = [$request->all()];
            }

            $saved = [];

            foreach ($dataArray as $data) {
                $validated = validator($data, [
                    'device_id'  => 'required|string|max:50',
                    'latitude'   => 'required|numeric|between:-90,90',
                    'longitude'  => 'required|numeric|between:-180,180',
                    'altitude'   => 'nullable|numeric',
                    'speed'      => 'nullable|numeric',
                    'satellites' => 'nullable|integer',
                    'timestamp'  => 'nullable|string',
                ])->validate();

                $validated['timestamp'] = isset($validated['timestamp']) 
                    ? Carbon::parse($validated['timestamp'])->toDateTimeString() 
                    : now()->toDateTimeString();

                $gps = Gps::create($validated);
                $saved[] = $gps->id;

                Log::info('Position GPS reçue', $validated);
            }

            return response()->json([
                'status'  => 'ok',
                'message' => 'Positions GPS enregistrées avec succès',
                'count'   => count($saved),
                'ids'     => $saved
            ], 201);

        } catch (\Throwable $e) {
            Log::error('Erreur lors de l’enregistrement GPS', [
                'message' => $e->getMessage(),
                'input'   => $request->all()
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Impossible d’enregistrer les positions GPS',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🔁 Récupération de la dernière position GPS
     */
    public function latest()
    {
        $gps = Gps::latest()->first();

        if (!$gps) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aucune position GPS trouvée'
            ], 404);
        }

        return response()->json([
            'status' => 'ok',
            'data'   => $gps
        ]);
    }

    /**
     * 📄 Récupération des 10 dernières positions GPS
     */
    public function index()
    {
        return response()->json(Gps::latest()->take(10)->get());
    }
}
