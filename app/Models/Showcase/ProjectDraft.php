<?php

namespace App\Models\Showcase;

use App\Models\FileUpload;
use Illuminate\Database\Eloquent\Model;

class ProjectDraft extends Model
{
    protected $connection = 'showcase';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'project_start_date',
        'project_end_date',
        'status',
        'logo_file_upload_id',
        'cover_file_upload_id',
    ];

    public function galleryPictures()
    {
        return $this->hasMany(ProjectGalleryPicture::class);
    }

    public function getLogoFile()
    {
        return $this->belongsTo(FileUpload::class, 'logo_file_upload_id');
    }

    public function getCoverFile()
    {
        return $this->belongsTo(FileUpload::class, 'cover_file_upload_id');
    }

    public function getCategories()
    {
        return $this->belongsToMany(ProjectCategory::class, 'project_category_pivots');
    }
}
