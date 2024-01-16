<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $connection = 'showcase';

    protected $fillable = [
        'name',
        'slug',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];
}
