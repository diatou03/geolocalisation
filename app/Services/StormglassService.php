<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class StormglassService
{
    public function getTides(string $date, float $lat, float $lng): ?array
    {
        $start = Carbon::parse($date)->startOfDay()->toIso8601String();
        $end = Carbon::parse($date)->addDay()->startOfDay()->toIso8601String();

        $response = Http::withHeaders([
            'Authorization' => env('STORMGLASS_API_KEY'),
        ])->get('https://api.stormglass.io/v2/tide/extremes/point', [
            'lat' => $lat,
            'lng' => $lng,
            'start' => $start,
            'end' => $end,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
