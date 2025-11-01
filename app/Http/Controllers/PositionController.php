<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
     public function store(Request $request)
    {
        $data = $request->validate([
            'device_id'  => 'required|string',
            'latitude'   => 'required|numeric',
            'longitude'  => 'required|numeric',
            'altitude'   => 'nullable|numeric',
            'speed'      => 'nullable|numeric',
            'satellites' => 'nullable|integer',
            'timestamp'  => 'nullable|string',
        ]);

        $position = Position::create($data);

        \Log::info('📍 Données de position reçues', $data);

        return response()->json([
            'status'  => 'ok',
            'message' => 'Position enregistrée avec succès',
            'data'    => $position
        ]);
    }

    public function index()
{
    $positions = \App\Models\Position::latest()->get();
    return view('position.index', compact('positions'));
}

        public function getPositions()
    {
        // Récupère toutes les positions (ou les plus récentes si vous voulez limiter)
        $positions = Position::orderBy('created_at', 'desc')->get();
        return response()->json($positions);
    }
    public function apiIndex()
   {
    return response()->json(\App\Models\Position::latest()->take(20)->get());
   }
    public function map()
    {
    return view('positions.map');
    }

}
