<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
