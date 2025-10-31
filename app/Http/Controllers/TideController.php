<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TideService;
use Carbon\Carbon;

class TideController extends Controller
{
    protected TideService $tideService;
    protected array $locations;

    public function __construct(TideService $tideService)
    {
        $this->tideService = $tideService;
        $this->locations = config('tides.locations');
    }

    public function index(Request $request)
    {
        $regionKey = $request->input('region');
        $regions = $this->locations;

        if (!$regionKey || !isset($regions[$regionKey])) {
            $regionKey = null;
            $communes = [];
            $communeKey = null;
            $tideData = [];
            $forecastData = [];
        } else {
            $communes = $regions[$regionKey]['communes'] ?? [];
            $communeKey = $request->input('commune', array_key_first($communes));

            if (!$communeKey || !isset($communes[$communeKey])) {
                $communeKey = null;
                $tideData = [];
                $forecastData = [];
            } else {
                $communeName = $communes[$communeKey]['name'];
                $coords = $this->tideService->getCoordinates($communeName);

                if ($coords && $coords['lat'] && $coords['lng']) {
                    $lat = $coords['lat'];
                    $lon = $coords['lng'];
                    $date = $request->input('date', now()->toDateString());
                    $forecastData = $this->tideService->getForecast($date, $lat, $lon, 3);
                    $tideData = $forecastData[$date] ?? [];
                } else {
                    $tideData = [];
                    $forecastData = [];
                }
            }
        }

        return view('tides.index', [
            'regions' => $regions,
            'selectedRegion' => $regionKey,
            'communes' => $communes ?? [],
            'selectedCommune' => $communeKey ?? null,
            'tideData' => $tideData ?? [],
            'forecastData' => $forecastData ?? [],
            'date' => $request->input('date', now()->toDateString()),
            'lat' => $lat ?? null,
            'lon' => $lon ?? null,
        ]);
    }
}
