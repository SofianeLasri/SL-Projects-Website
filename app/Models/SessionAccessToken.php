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

    /**
     * Annule tous les tokens actifs pour un utilisateur donné.
     */
    public static function cancelAllActiveTokensForUser(User $user): void
    {
        $user->sessions->each(function (Session $session) {
            $session->sessionAccessTokens->each(function (SessionAccessToken $sessionAccessToken) {
                $sessionAccessToken->expires_at = now();
                $sessionAccessToken->save();
            });
        });
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    /**
     * Génère un token aléatoire et unique.
     */
    public function generateToken(): void
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
