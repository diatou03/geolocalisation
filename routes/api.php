<?php
use App\Http\Controllers\TideApiController;
use App\Http\Controllers\TideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\MeshtasticController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Toutes les routes ici ont le préfixe "/api"
| Exemple : http://127.0.0.1:8000/api/weather
*/

Route::get('/ping', fn() => response()->json(['message' => 'API OK ✅']));

// =======================
// MÉTÉO (API JSON pour ESP32 ou JS)
// =======================
Route::get('/weather', [WeatherController::class, 'index'])->name('api.weather');
Route::get('/weather/{id}', [WeatherController::class, 'show'])->name('api.weather.show');
Route::post('/weather', [WeatherController::class, 'store'])->name('api.weather.store');

// =======================
//  MARÉES
// =======================
Route::get('/tides', [TideApiController::class, 'index'])->name('api.tides');

// =======================
//  GPS
// =======================
Route::post('/gps', [GpsController::class, 'store'])->name('api.gps.store');
Route::get('/gps/latest', [GpsController::class, 'latest'])->name('api.gps.latest');
Route::get('/gps', [GpsController::class, 'index'])->name('api.gps.index');

Route::post('/gps', [GpsController::class, 'store']);   // Recevoir les données GPS
Route::get('/gps/latest', [GpsController::class, 'latest']); // Dernière position
Route::get('/gps', [GpsController::class, 'index']);        // 10 dernières positions
// =======================
//  MESH NETWORK
// =======================
Route::post('/meshtastic', [MeshtasticController::class, 'store'])->name('api.meshtastic.store');

// =======================
//  POSITIONS
// =======================
Route::get('/positions', [PositionController::class, 'index'])->name('api.positions.index');
Route::post('/positions', [PositionController::class, 'store'])->name('api.positions.store');
Route::get('/positions', [PositionController::class, 'apiIndex']);