<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Model
{
    protected $connection = 'main';

    protected $fillable = [
        'name',
        'filename',
        'path',
        'type',
        'size',
    ];

    public function getVariantsIfPicture()
    {
        return $this->hasMany(PictureType::class);
    }

    public function getThumbnailVariant()
    {
        return $this->hasOne(PictureType::class)->where('type', 'thumbnail');
    }

    public function getSmallVariant()
    {
        return $this->hasOne(PictureType::class)->where('type', 'small');
    }

    public function getMediumVariant()
    {
        return $this->hasOne(PictureType::class)->where('type', 'medium');
    }

    public function getLargeVariant()
    {
        return $this->hasOne(PictureType::class)->where('type', 'large');
    }

    public function getOriginalVariant()
    {
        return $this->hasOne(PictureType::class)->where('type', 'original');
    }

    public function getFileUrl()
    {
        return Storage::url($this->path.'/'.$this->filename);
    }
}
