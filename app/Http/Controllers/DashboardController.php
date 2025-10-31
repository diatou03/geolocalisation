<?php

namespace App\Http\Controllers;
use App\Models\AgentMarin;
use App\Models\Alerte;
use App\Models\Meteo;
use App\Models\Pirogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
    $alertes = Alerte::latest()->take(5)->get();
    $meteos = Meteo::latest()->take(5)->get();
    $pirogues = Pirogue::with('localisation')->take(5)->get();
    $agentMarins = AgentMarin::latest()->take(5)->get();

    

    // On suppose que tu as déjà les extrêmes (marées hautes/basses)
    // Tu peux les charger depuis un modèle ou une API selon ton app
    $extremes = Cache::get('extremes'); // ou $this->getMarées() si tu as une méthode

    $nextTide = null;
    if ($extremes) {
        $nextTide = collect($extremes)
            ->filter(fn($e) => \Carbon\Carbon::parse($e['datetime'])->gt(now()))
            ->sortBy('datetime')
            ->first();
    }

    return view('dashboard.index', compact('alertes', 'meteos', 'pirogues', 'nextTide' , 'agentMarins'));
}
public $period = 'week';
public function render()
{
    return view('livewire.dashboard', [
        'cardStats' => [
            ['label'=>'Alertes', 'count'=>Alerte::count(), 'route'=>'alertes.index', 'icon'=>'bell', 'color'=>'red'],
            ['label'=>'Pirogues actives', 'count'=>Pirogue::where('active',1)->count(), 'route'=>'pirogues.index', 'icon'=>'ship', 'color'=>'indigo'],
            ['label'=>'Enregistrements GPS', 'count'=>GpsRecord::count(), 'route'=>'gps.map', 'icon'=>'map-marker-alt', 'color'=>'blue'],
            ['label'=>'Lectures météo', 'count'=>WeatherReading::count(), 'route'=>'weather.show', 'icon'=>'cloud-rain', 'color'=>'green'],
        ]
    ]);
}

}

