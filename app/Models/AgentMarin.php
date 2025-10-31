<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentMarin extends Model
{
     protected $fillable = ['nom', 'prenom', 'telephone', 'email', 'poste'];
}
