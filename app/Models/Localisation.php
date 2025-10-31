<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
     protected $table = 'localisations'; // garde l’ancien nom de table
     protected $fillable = ['lat', 'lng', 'device_id']; 
     
    public function meteos(): HasMany
    {
        return $this->hasMany(Meteo::class);
    }

      public function alertes()
  {
      return $this->hasMany(Arte::class);
  }
 public function pirogues()
    {
        return $this->hasMany(Pirogue::class);
    }
}
