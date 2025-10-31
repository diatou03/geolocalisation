<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MeteoService;

class MeteoController extends Controller
{
    protected $meteoService;

    public function __construct(MeteoService $meteoService)
    {
        $this->meteoService = $meteoService;
    }

    public function current()
    {
        $data = $this->meteoService->getLatest();

        return response()->json($data);
    }
}

