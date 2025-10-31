<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class meteo extends Model
{
    protected $fillable = [
    'ville', 'temperature', 'description',
    'vitesse_vent', 'direction_vent',
    'humidite', 'heure',
];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

      public function localisation()
  {
      return $this->belongsTo(Localisation::class);
  }

}
