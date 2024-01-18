<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class ProjectBuildingBloc extends Model
{
    protected $connection = 'showcase';

    public $timestamps = false;

    protected $table = 'projects_building_blocs';

    protected $fillable = [
        'group_id',
        'type',
        'translation_index',
        'file_upload_id',
        'youtube_url',
    ];
}
