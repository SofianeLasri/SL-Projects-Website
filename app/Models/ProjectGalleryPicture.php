<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectGalleryPicture extends Model
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function fileUpload()
    {
        return $this->belongsTo(FileUpload::class);
    }
}