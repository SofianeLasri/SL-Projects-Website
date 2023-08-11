<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    public $timestamps = false;

    public $incrementing = false;

    protected $connection = 'main';

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'ip_adress_id',
        'user_agent',
        'payload',
        'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sessionAccessTokens(): HasMany
    {
        return $this->hasMany(SessionAccessToken::class);
    }
}
