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
        'file_upload_id',
        'link',
        'project_id',
    ];
}
