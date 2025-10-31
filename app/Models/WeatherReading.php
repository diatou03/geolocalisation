<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherReading extends Model
{
    protected $fillable = [
        'device_id','city','lat','lng',
        'temperature','humidity','description','captured_at'
    ];
    protected $casts = [
        'captured_at' => 'datetime',
    ];
}
