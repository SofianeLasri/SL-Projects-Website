<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectChronology extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'date',
        'name',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
