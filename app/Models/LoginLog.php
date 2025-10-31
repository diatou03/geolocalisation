<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'user_id',
        'ip',
        'city',
        'country',
        'latitude',
        'longitude',
    ];

    protected $table = 'logins'; // si ta table s'appelle encore "logins"

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
