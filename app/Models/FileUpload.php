<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $fillable = [
        'name',
        'filename',
        'type',
        'size',
    ];

    public function getVariantsIfPicture()
    {
        return $this->hasMany(PictureType::class);
    }
}
