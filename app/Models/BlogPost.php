<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $primaryKey = ["id", "enum", "slug"];
    public $incrementing = false;
}
