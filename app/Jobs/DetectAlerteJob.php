<?php

namespace App\Jobs;
use App\Jobs\DetectAlerteJob;
use App\Models\Pirogue;
use App\Models\Alerte;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DetectAlerteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected array $input)
    {
        //
    }

    public function handle()
    {
        $pirogue = Pirogue::find($this->input['id']);
        if (! $pirogue) return;

        $current = [
            'lat' => $this->input['lat'],
            'lng' => $this->input['lng'],
        ];

        if ($this->estEnZoneDanger($current)) {
            Alerte::create([
                'pirogue_id'  => $pirogue->id,
                'type'        => 'zone_danger',
                'message'     => 'Approche zone dangereuse / frontière',
                'latitude'    => $current['lat'],
                'longitude'   => $current['lng'],
            ]);
        }

        // Ajoutez d'autres vérifications (ex. météo, détresse…).
    }

    private function estEnZoneDanger(array $coords): bool
    {
        // Géofence ou logique ici
        return false;
    }
    
public function reception(Request $req)
{
    DetectAlerteJob::dispatch($req->only('id','lat','lng'));
    return response()->json(['status' => 'queued']);
}
}
