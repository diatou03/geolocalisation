<?php

use App\Http\Controllers\PirogueController;
use App\Http\Controllers\MeteoController;
use App\Http\Controllers\LocalisationController;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\GpsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\TideController;
use App\Http\Controllers\AgentMarinController;
use App\Http\Controllers\LoginLogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

// Route::get('/', function () {
    // return view('welcome');
// });

// Pirogues
Route::resource('pirogues', PirogueController::class);
Route::post('pirogues/{pirogue}/panic', [PirogueController::class, 'panic'])->name('pirogues.panic');
Route::get('/pirogues/map', [PirogueController::class, 'map'])->name('pirogues.map');

// Météo
Route::resource('meteo', MeteoController::class);
Route::get('/meteo/{id}', [PirogueController::class, 'meteoShow'])->name('meteo.show');
Route::get('/meteo', [MeteoController::class, 'index'])->name('meteo.index');
Route::get('/meteo/current', [MeteoController::class, 'current'])->name('meteo.current');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Weather (Météo avancée)
Route::get('/weather', [WeatherController::class, 'index'])->name('weather.show'); // utilise weather.show pour cohérence avec ton blade
Route::get('/weather', [WeatherController::class, 'show'])->name('weather.show');
// Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
Route::get('/weather/index', [WeatherController::class, 'index'])->name('weather.index');
Route::get('/weather/{city}', [WeatherController::class, 'show'])->name('weather.show');
// Route::get('/weather', [WeatherController::class, 'show'])->name('weather.show');
// Route::post('/weather', [WeatherController::class, 'fetch'])->name('weather.fetch');
// Route::match(['get', 'post'], '/weather', [WeatherController::class, 'fetch'])->name('weather.fetch');

// Alertes
Route::resource('alertes', AlerteController::class);
Route::get('alertes/map', [AlerteController::class, 'map'])->name('alertes.map');
Route::post('/alertes', [AlerteController::class, 'store'])->name('alertes.store');

// Localisations
Route::resource('localisations', LocalisationController::class);
Route::post('/api/localisations/update', [LocalisationController::class, 'apiUpdate'])->name('localisations.apiUpdate');

// GPS
// Route::get('/gps', [GpsController::class, 'index'])->name('gps.index');
// Route::get('/gps/map', [GpsController::class, 'map'])->name('gps.map');
// Route::post('/gps/store', [GpsController::class, 'store'])->name('gps.store');
// Vue avec la carte et le bouton
// Route::get('/gps', [GpsController::class, 'map'])->name('gps.map');
Route::get('/gps/map', [GpsController::class, 'map'])->name('gps.map');

// Requête AJAX pour localiser via IP
// Route::post('/gps/locate', [GpsController::class, 'locateByIp'])->name('gps.locate');
Route::post('/locate-by-ip', [GpsController::class, 'locateByIp']);
// Géolocalisation par IP
Route::get('/gps/ip', [GpsController::class, 'locateByIp']);
// Page carte
// Route::get('/gps/map', [GpsController::class, 'map']);
Route::get('/gps', [GpsController::class, 'index'])->name('gps.index');


// Admin
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/positions', [AdminController::class, 'index'])->name('admin.positions.index');
});
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

// Marées
Route::resource('tides', TideController::class);
Route::get('/tides/map', function () { return view('tides.map'); })->name('tides.map');

// Agents marins
Route::resource('agent_marins', AgentMarinController::class);

// Logout form route (si tu gères logout via POST)
Route::post('/logout', function(Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Offline view
// Route::view('/offline', 'offline');
//  Route::post('logins', [LoginLogController::class, 'logins']);
//  Route::get('/logins', [LoginLogController::class, 'index'])->name('logins.index');
 // ou ton contrôleur de connexion

// Page d'accueil publique
// Route::get('/', function () {
    // return view('welcome');
// })->name('home');

// Tableau de bord (protégé)
// Route::get('/dashboard', function () {
    // return view('dashboard.index');
// })->middleware('auth')->name('dashboard');

// Routes pour la gestion des positions GPS
Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
Route::get('/positions/json', [PositionController::class, 'getPositions'])->name('positions.json');
Route::post('/api/positions', [PositionController::class, 'store'])->name('positions.store');

Route::post('/positions', [PositionController::class, 'store']);

// Authentification
Route::get('/logs', [LoginlogController::class, 'logs'])->name('login.logs');
Route::post('/logout', [LoginlogController::class, 'logout'])->name('logout');

// --- API météo et marées (accès public) ---
// Page d'accueil publique
Route::get('/', [HomeController::class, 'index'])->name('home');

// API météo et marées pour JS (JSON)
Route::get('/api/weather', [HomeController::class, 'weather'])->name('api.weather');
Route::get('/api/tides', [HomeController::class, 'tides'])->name('api.tides');

// --- Authentification ---
// Route::get('/login', [LoginlogController::class, 'login']);
// Route::get('/login', [LoginlogController::class, 'index'])->name('login');
// Route::get('/login', [LoginlogController::class, 'index'])->name('login.index');
// Route::post('/login', [LoginlogController::class, 'authenticate'])->name('login.post');
// Route::get('/login', [LoginlogController::class, 'index'])->name('login.post');
// Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

// Traitement du login
// Route::get('/register', [LoginlogController::class, 'registerForm'])->name('register');
// Route::post('/register', [LoginlogController::class, 'register'])->name('register.post');
// Route::post('/logout', [LoginlogController::class, 'logout'])->name('logout');

// --- Tableau de bord (protégé par login) ---
// Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/welcome', function () {
    return view('welcome');
});

// Routes météo
// Route::get('/weather', [WeatherController::class, 'getWeatherJson'])->name('weather.json'); // pour fetch JS
Route::get('/weather/{city?}', [WeatherController::class, 'show'])->name('weather.show'); // pour page météo complète

// Routes marées
Route::get('/tides', [TideController::class, 'getTidesJson'])->name('tides.json'); 
Route::get('/tides', [TideController::class, 'index'])->name('tides.index');

// / Page de connexion
Route::get('/login', [LoginlogController::class, 'index'])->name('login');

// Traitement du login
Route::post('/login', [LoginlogController::class, 'authenticate'])->name('login.post');

// Page d'inscription
Route::get('/register', [LoginlogController::class, 'registerForm'])->name('register');

// Traitement de l'inscription
Route::post('/register', [LoginlogController::class, 'register'])->name('register.post');

// Déconnexion
Route::post('/logout', [LoginlogController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth')->name('dashboard');

// Logs des connexions (optionnel, pour admin)
Route::get('/login-logs', [LoginlogController::class, 'logs'])->name('login.logs')->middleware('auth');

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');
// Route::get('/weather', [WelcomeController::class, 'weather'])->name('weather.show');
// Route::get('/tides', [WelcomeController::class, 'index'])->name('tides.index');

Route::get('/', [WelcomeController::class, 'weather'])->name('welcome');
 Route::get('/weather', [WelcomeController::class, 'weather'])->name('weather.show');
// Route::get('/api/weather', [WeatherController::class, 'weather'])->name('weather.api');

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');