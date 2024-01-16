<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class ProjectBuildingBlocGroup extends Model
{
    protected $connection = 'showcase';

    public $timestamps = false;

    protected $table = 'projects_building_blocs_groups';

    protected $fillable = [
        'order',
        'project_id',
    ];
}
