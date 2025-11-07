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

    // le nom de la table
    protected $table = 'login_logs';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
