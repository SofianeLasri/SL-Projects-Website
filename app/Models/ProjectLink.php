<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectLink extends Model
{
    protected $primaryKey = ["project_id", "type"];
    public $incrementing = false;
    public $timestamps = false;
}
