<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPostCategoryPivot extends Model
{
    protected $primaryKey = ["blog_post_id", "category_id"];
    public $incrementing = false;
    public $timestamps = false;
}
