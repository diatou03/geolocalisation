<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\Log;

class PositionController extends Controller
{
    /**
     * 🛰️ Enregistre une ou plusieurs positions envoyées depuis l’ESP32 (API POST)
     */
    public function store(Request $request)
    {
        $payload = $request->json()->all();

        if (empty($payload)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Aucune donnée reçue ou JSON invalide',
                'count'   => 0,
                'data'    => []
            ], 400);
        }

        // Si c'est un seul objet, on le convertit en tableau
        if (isset($payload['device_id'])) {
            $payload = [$payload];
        }

        $saved = [];
        foreach ($payload as $item) {
            $data = validator($item, [
                'device_id'  => 'required|string',
                'latitude'   => 'required|numeric',
                'longitude'  => 'required|numeric',
                'altitude'   => 'nullable|numeric',
                'speed'      => 'nullable|numeric',
                'satellites' => 'nullable|integer',
                'timestamp'  => 'nullable|string',
            ])->validate();

            $position = Position::create($data);
            $saved[] = $position;
        }

        Log::info('📍 Positions reçues et stockées avec succès', $saved);

        return response()->json([
            'status'  => 'ok',
            'message' => 'Positions enregistrées avec succès',
            'count'   => count($saved),
            'data'    => $saved
        ], 201);
    }

    /**
     * 🌐 Affiche la liste des positions ou les renvoie en JSON selon le contexte
     */
    public function index()
    {
        if (request()->is('api/*')) {
            $positions = Position::latest()->take(20)->get();

            return response()->json([
                'status' => 'ok',
                'count'  => $positions->count(),
                'data'   => $positions
            ]);
        }

        // Vue HTML classique
        $positions = Position::latest()->paginate(10);
        return view('position.index', compact('positions'));
    }

    /**
     * Retourne toutes les positions en JSON (pour ton ESP ou tests API)
     */
    public function getPositions()
    {
        $positions = Position::latest()->get();
        return response()->json([
            'status' => 'ok',
            'count'  => $positions->count(),
            'data'   => $positions
        ]);
    }

    /**
     *  Affiche la carte avec les positions
     */
    public function map()
    {
        return view('position.map');
    }
}
