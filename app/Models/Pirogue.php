<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pirogue extends Model
{
    protected $fillable = ['matricule', 'nom', 'description', 'type', 'date_creation'];

       protected $casts = [
        'date_creation' => 'datetime',
    ];
    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    /**
     * Relation pour récupérer uniquement la dernière position.
     */
      public function latestPosition()
    {
        // Si latestOfMany existe dans ta version de Laravel
        try {
            return $this->hasOne(Position::class)->latestOfMany('created_at');
        } catch (\BadMethodCallException $e) {
            // fallback manuel si la version ne supporte pas latestOfMany
            return $this->hasOne(Position::class)->orderBy('created_at', 'desc');
        }
    }
    public function localisation()
    {
        return $this->belongsTo(Localisation::class);
    }
}
