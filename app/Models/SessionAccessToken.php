<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SessionAccessToken extends Model
{
    protected $connection = 'main';

    protected $fillable = [
        'session_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function generateToken()
    {
        // On génère un token aléatoire
        $token = Str::random(32);

        // On vérifie que le token n'existe pas déjà
        $tokenExists = self::where('token', $token)->first();

        // Si le token existe déjà, on en génère un nouveau
        if ($tokenExists) {
            $this->generateToken();
        } else {
            $this->token = $token;
        }
    }
}
