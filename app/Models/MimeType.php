<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MimeType extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'value',
    ];
}
