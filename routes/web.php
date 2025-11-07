<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PirogueController, MeteoController, LocalisationController, AlerteController,
    GpsController, AdminController, DashboardController, WeatherController,
    TideController, AgentMarinController, LoginLogController, PositionController,
    WelcomeController, HomeController
};

// 🌍 Routes publiques
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/welcome', [WelcomeController::class, 'index']);
Route::get('/register', [LoginLogController::class, 'registerForm'])->name('register');
Route::post('/register', [LoginLogController::class, 'register'])->name('register.post');
Route::get('/login', [LoginLogController::class, 'index'])->name('login');
Route::post('/login', [LoginLogController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [LoginLogController::class, 'logout'])->name('logout');
Route::get('/weather/{city?}', [WeatherController::class, 'show'])->name('weather.show');

// 🌊 Données publiques
Route::get('/tides', [TideController::class, 'index'])->name('tides.index');
Route::get('/api/weather', [HomeController::class, 'weather'])->name('api.weather');
Route::get('/api/tides', [HomeController::class, 'tides'])->name('api.tides');
Route::get('/api/positions', [PositionController::class, 'index'])->name('api.positions.index');
Route::get('positions/map', [PositionController::class, 'map'])->name('positions.map');

// 🔒 Routes protégées (auth obligatoire pour tous les utilisateurs)
Route::middleware(['auth'])->group(function () {
    // Dashboard utilisateur
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Ressources accessibles à tout utilisateur connecté
    Route::resource('localisations', LocalisationController::class);
    Route::post('/api/localisations/update', [LocalisationController::class, 'apiUpdate'])->name('localisations.apiUpdate');

    Route::get('/gps', [GpsController::class, 'index'])->name('gps.index');
    Route::get('/gps/map', [GpsController::class, 'showMap'])->name('gps.map');
    Route::post('/gps/locate', [GpsController::class, 'locateByIp'])->name('gps.locate');
    Route::get('/gps/ip', [GpsController::class, 'locateByIp']);

    Route::resource('alertes', AlerteController::class);
    Route::get('alertes/map', [AlerteController::class, 'map'])->name('alertes.map');

    Route::resource('tides', TideController::class);
    Route::get('/tides/map', fn () => view('tides.map'))->name('tides.map');
    Route::get('/tides/json', [TideController::class, 'getTidesJson'])->name('tides.json');
});

// 🔒 Routes protégées (auth + admin uniquement)
// Route::middleware(['auth', 'admin'])->group(function () {
    // Espace admin
    // Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    // Route::get('/admin/positions', [AdminController::class, 'index'])->name('admin.positions.index');

    // Ressources réservées aux admins
    Route::resource('pirogues', PirogueController::class);
    Route::resource('agent_marins', AgentMarinController::class);

    // Logs de connexion (admin uniquement)
    Route::get('/login-logs', [LoginLogController::class, 'logs'])->name('login.logs');
// });
