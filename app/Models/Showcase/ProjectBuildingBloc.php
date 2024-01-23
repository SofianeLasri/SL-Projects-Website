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
        'translation_id',
        'file_upload_assembly_id',
        'youtube_url',
    ];
}
