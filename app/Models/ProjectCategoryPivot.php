<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategoryPivot extends Model
{
    protected $primaryKey = ["project_id", "category_id"];
    public $incrementing = false;
    public $timestamps = false;
}
