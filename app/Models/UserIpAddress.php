<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserIpAddress extends Model
{
    protected $connection = 'main';

    protected $fillable = [
        'user_id',
        'ip_adress_id',
    ];

    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}
