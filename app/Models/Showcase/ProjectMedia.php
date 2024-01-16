<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class ProjectMedia extends Model
{
    protected $connection = 'showcase';

    public $timestamps = false;

    protected $fillable = [
        'display_order',
        'type',
        'fileupload_id',
        'link',
        'project_id',
    ];
}
