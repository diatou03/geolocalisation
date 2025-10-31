<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Alerte;
use App\Models\Pirogue;
use App\Models\GpsRecord;
use App\Models\WeatherReading;

class Dashboard extends Component
{
    public $period = 'week';

    public function render()
    {
        return view('livewire.dashboard', [
            'cards' => [
                ['label'=>'Alertes', 'count'=>Alerte::count(), 'route'=>route('alertes.index'), 'icon'=>'bell', 'color'=>'red'],
                ['label'=>'Pirogues actives', 'count'=>Pirogue::where('active',1)->count(), 'route'=>route('pirogues.index'), 'icon'=>'ship', 'color'=>'indigo'],
                ['label'=>'GPS Records', 'count'=>GpsRecord::count(), 'route'=>route('gps.map'), 'icon'=>'map-marker-alt', 'color'=>'blue'],
                ['label'=>'Lectures météo', 'count'=>WeatherReading::count(), 'route'=>route('weather.show'), 'icon'=>'cloud-rain', 'color'=>'green'],
            ]
        ]);
    }
}
