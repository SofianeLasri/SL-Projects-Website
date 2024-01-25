<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class ProjectDraft extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'description',
        'content_translation_id',
        'release_status',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
    ];
}
