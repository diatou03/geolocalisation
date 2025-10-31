<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TideApiController extends Controller
{
    public function getData(Request $request)
    {
        $locations = [
            'Dakar'       => [14.67, -17.42],
            'Ziguinchor'  => [12.58, -16.28],
            'Kaolack'     => [14.15, -16.12],
            'Saint‑Louis' => [16.02, -16.48],
        ];

        $zone = $request->query('zone', 'Dakar');
        $coords = $locations[$zone] ?? $locations['Dakar'];

        [$lat, $lon] = $coords;

        $response = Http::get('https://www.worldtides.info/api/v3', [
            'extremes' => true,
            'lat'      => $lat,
            'lon'      => $lon,
            'days'     => 1,
            'key'      => config('services.worldtides.key'),
        ]);

        $data = $response->json();

        return response()->json([
            'zone' => $zone,
            'extremes' => $data['extremes'] ?? [],
        ]);
    }
}
