<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDraftMedia extends Model
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
