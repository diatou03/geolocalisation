<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TideService
{
    protected string $stormGlassKey;
    protected string $openCageKey;

    public function __construct()
    {
        $this->stormGlassKey = env('STORMGLASS_API_KEY', '');
        $this->openCageKey = env('OPENCAGE_API_KEY', '');

        if (empty($this->stormGlassKey)) {
            Log::error('STORMGLASS_API_KEY non défini dans .env');
        }
        if (empty($this->openCageKey)) {
            Log::error('OPENCAGE_API_KEY non défini dans .env');
        }
    }

    public function getTides(string $date, float $lat, float $lon): array
    {
        if (empty($this->stormGlassKey)) {
            return $this->fallbackTides($date);
        }

        $start = Carbon::parse($date)->startOfDay()->timestamp;
        $end = Carbon::parse($date)->endOfDay()->timestamp;

        $url = "https://api.stormglass.io/v2/tide/extremes/point";

        try {
            $response = Http::timeout(20)
                ->withHeaders(['Authorization' => $this->stormGlassKey])
                ->get($url, ['lat' => $lat, 'lng' => $lon, 'start' => $start, 'end' => $end]);

            if ($response->successful()) {
                $data = $response->json();
                return collect($data['data'] ?? [])->map(function ($item) {
                    return [
                        'time' => $item['time'] ?? null,
                        'height' => $item['height'] ?? null,
                        'type' => strtolower($item['type'] ?? 'unknown'),
                    ];
                })->toArray() ?: $this->fallbackTides($date);
            }

            Log::warning('StormGlass API returned error', ['status' => $response->status(), 'body' => $response->body()]);
        } catch (\Exception $e) {
            Log::error('StormGlass API request failed', ['error' => $e->getMessage()]);
        }

        return $this->fallbackTides($date);
    }

    protected function fallbackTides(string $date): array
    {
        return [
            ['time' => $date . ' 03:00:00', 'height' => 3.2, 'type' => 'high'],
            ['time' => $date . ' 09:00:00', 'height' => 1.1, 'type' => 'low'],
            ['time' => $date . ' 15:00:00', 'height' => 3.0, 'type' => 'high'],
            ['time' => $date . ' 21:00:00', 'height' => 1.2, 'type' => 'low'],
        ];
    }

    public function getCoordinates(string $communeName): ?array
    {
        if (empty($this->openCageKey)) return null;

        try {
            $response = Http::timeout(20)->get('https://api.opencagedata.com/geocode/v1/json', [
                'q' => $communeName . ', Senegal',
                'key' => $this->openCageKey,
                'limit' => 1,
                'no_annotations' => 1,
            ]);

            $results = $response->json('results');
            if (!empty($results)) {
                $geo = $results[0]['geometry'] ?? [];
                return ['lat' => $geo['lat'] ?? null, 'lng' => $geo['lng'] ?? null];
            }

            Log::warning('OpenCage API géocodage échoué', ['commune' => $communeName]);
        } catch (\Exception $e) {
            Log::error('OpenCage API request failed', ['error' => $e->getMessage()]);
        }

        return null;
    }

    public function getForecast(string $startDate, float $lat, float $lon, int $days = 3): array
    {
        $forecast = [];
        for ($i = 0; $i < $days; $i++) {
            $date = Carbon::parse($startDate)->addDays($i)->toDateString();
            $forecast[$date] = $this->getTides($date, $lat, $lon);
        }
        return $forecast;
    }
}
