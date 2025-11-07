<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gps extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'ip', 'country', 'city', 'latitude', 'longitude',
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
