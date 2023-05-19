<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $connection = 'main';

    protected $fillable = [
        'ip_adress_id',
        'country_code',
        'url',
        'method',
        'user_agent',
        'referer',
        'origin',
        'content_type',
        'content_length',
        'user_id',
    ];

    public function ipAdress()
    {
        return $this->belongsTo(IpAdress::class);
    }
}
