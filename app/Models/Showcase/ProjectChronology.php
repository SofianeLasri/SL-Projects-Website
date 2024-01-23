<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class ProjectChronology extends Model
{
    public $timestamps = false;

    protected $table = 'projects_chronology';

    protected $fillable = [
        'date',
        'name_translation_id',
        'description_translation_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
