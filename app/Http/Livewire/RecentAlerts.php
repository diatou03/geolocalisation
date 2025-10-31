<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Alerte;

class RecentAlerts extends Component
{
    public function render()
    {
        return view('livewire.recent-alerts', [
            'alerts' => Alerte::latest()->limit(5)->get()
        ]);
    }
}
