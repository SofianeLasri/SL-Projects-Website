<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class IpAdress extends Model
{
    protected $connection = 'main';

    protected $fillable = [
        'ip',
    ];

    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public static function getIdFromCacheOrCreate(string $ip): int
    {
        $ipHash = md5($ip);
        $cacheKey = "ip_adress_id_{$ipHash}";
        $ipAdressId = Cache::has($cacheKey) ? Cache::get($cacheKey) : null;

        if ($ipAdressId === null) {
            $ipAdress = IpAdress::firstOrCreate(['ip' => $ip]);
            $ipAdressId = $ipAdress->id;
            Cache::put($cacheKey, $ipAdressId, 60 * 24);
        }

        return $ipAdressId;
    }
}
