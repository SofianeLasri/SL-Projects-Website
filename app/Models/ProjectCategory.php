<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $connection = 'showcase';
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_category_pivots');
    }

    public function getLogoFile()
    {
        return $this->belongsTo(FileUpload::class, 'logo_file_upload_id');
    }

    public function getCoverFile()
    {
        return $this->belongsTo(FileUpload::class, 'cover_file_upload_id');
    }
}
