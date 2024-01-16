<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class ProjectCover extends Model
{
    protected $connection = 'showcase';

    public $timestamps = false;

    protected $fillable = [
        'file_upload_id',
        'ratio',
    ];
}
