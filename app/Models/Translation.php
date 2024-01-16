<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $connection = 'main';

    public $timestamps = false;

    protected $fillable = [
        'index',
        'country_code',
        'message',
    ];
}
