<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UserAgent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_agent',
    ];

    public static function getIdFromCacheOrCreate(string $userAgent): int
    {
        $userAgentHash = md5($userAgent);
        $cacheKey = "user_agent_id_{$userAgentHash}";
        $userAgentId = Cache::has($cacheKey) ? Cache::get($cacheKey) : null;

        if ($userAgentId === null) {
            $userAgent = UserAgent::firstOrCreate(['user_agent' => $userAgent]);
            $userAgentId = $userAgent->id;
            Cache::put($cacheKey, $userAgentId, 60 * 24);
        }

        return $userAgentId;
    }
}
