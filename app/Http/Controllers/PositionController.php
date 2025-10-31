<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    public function store(Request $request)
    {
        $position = Position::create([
            'device_id'  => $request->device_id ?? 'T-Beam',
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
            'speed'      => $request->speed ?? 0,
            'altitude'   => $request->altitude ?? 0,
            'satellites' => $request->satellites ?? 0,
            'timestamp' => $request->timestamp,
        ]);

        return response()->json(['success'=>true]);
    }

    public function index()
    {
        return Position::orderBy('created_at','desc')->get();
    }
        public function getPositions()
    {
        // Récupère toutes les positions (ou les plus récentes si vous voulez limiter)
        $positions = Position::orderBy('created_at', 'desc')->get();
        return response()->json($positions);
    }
}
