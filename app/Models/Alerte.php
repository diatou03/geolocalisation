<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{

    protected $fillable = [
    'type',
    'message',
    'latitude',
    'longitude',
    'pirogue_id',
    'created_at',
    'updated_at',
];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
      public function localisation()
  {
      return $this->belongsTo(Localisation::class);
  }
  public function pirogue()
    {
        // App\Models\Pirogue est le modèle cible
        return $this->belongsTo(Pirogue::class, 'pirogue_id', 'id');
    }
}

