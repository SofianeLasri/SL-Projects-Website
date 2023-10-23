<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class ProjectDraftCategoryPivot extends Model
{
    public $timestamps = false;

    protected $connection = 'showcase';
}
