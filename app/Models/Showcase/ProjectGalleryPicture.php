<?php

namespace App\Models\Showcase;

use App\Models\FileUpload;
use Illuminate\Database\Eloquent\Model;

class ProjectGalleryPicture extends Model
{
    protected $connection = 'showcase';

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function fileUpload()
    {
        return $this->belongsTo(FileUpload::class);
    }
}
