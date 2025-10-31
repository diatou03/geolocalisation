<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsRecord extends Model
{
    protected $fillable = [
        'device_id', 'lat', 'lon', 'alt', 'captured_at',
    ];

    protected $casts = [
        'lat' => 'decimal:6',
        'lon' => 'decimal:6',
        'alt' => 'decimal:2',
        'captured_at' => 'datetime',
    ];
}