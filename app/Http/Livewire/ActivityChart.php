<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Alerte;
use Illuminate\Support\Carbon;

class ActivityChart extends Component
{
    public $period;

    public function getData()
    {
        $start = match($this->period) {
            'month' => now()->subMonth(),
            'year' => now()->subYear(),
            default => now()->subWeek(),
        };

        return Alerte::selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->where('created_at', '>=', $start)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');
    }

    public function render()
    {
        return view('livewire.activity-chart', [
            'data' => $this->getData()
        ]);
    }
}
