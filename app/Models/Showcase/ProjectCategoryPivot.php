<?php

namespace App\Models\Showcase;

use Illuminate\Database\Eloquent\Model;

class ProjectCategoryPivot extends Model
{
    public $timestamps = false;

    protected $connection = 'showcase';
}
