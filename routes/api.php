<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\GpsController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\TideApiController;
use App\Http\Controllers\TideController;
use App\Http\Controllers\MeshtasticController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Toutes les routes ici ont le préfixe "/api"
| Exemple : http://10.16.205.175/api/weather
*/

//  Test rapide pour vérifier que l’API fonctionne
Route::get('/ping', fn() => response()->json(['message' => 'API OK ']));

// =======================
// 🌦 MÉTÉO
// =======================
Route::get('/weather', [WeatherController::class, 'index'])->name('api.weather');
Route::get('/weather/{id}', [WeatherController::class, 'show'])->name('api.weather.show');
Route::post('/weather', [WeatherController::class, 'store'])->name('api.weather.store');

// =======================
// 🌊 MARÉES
// =======================
Route::get('/tides', [TideApiController::class, 'index'])->name('api.tides');

// =======================
// 📡 GPS
// =======================
Route::post('/gps', [GpsController::class, 'store'])->name('api.gps.store');
Route::get('/gps/latest', [GpsController::class, 'latest'])->name('api.gps.latest');
Route::get('/gps', [GpsController::class, 'index'])->name('api.gps.index');
Route::post('/gps/locate', [GpsController::class, 'locateByIp']);
Route::get('/gps/test', function (Request $request) {
    return response()->json([
        'latitude' => 14.7167,
        'longitude' => -17.4677,
        'city' => 'Dakar'
    ]);
});

// =======================
//  MESH NETWORK
// =======================
Route::post('/meshtastic', [MeshtasticController::class, 'store'])->name('api.meshtastic.store');

// =======================
// 📍 POSITIONS
// =======================
Route::post('/positions', [PositionController::class, 'store']);         // Envoi depuis ESP32
Route::get('/positions', [PositionController::class, 'index']);          // Dernières positions
Route::get('/positions/all', [PositionController::class, 'getPositions']); // Toutes les positions

Route::post('/positions', [PositionController::class, 'store'])->name('api.positions.store');
Route::get('/positions', [PositionController::class, 'index'])->name('api.positions.index');
Route::get('/positions/all', [PositionController::class, 'getPositions'])->name('api.positions.all');