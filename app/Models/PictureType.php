<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PictureType extends Model
{
    protected $fillable = [
        'file_upload_id',
        'type',
    ];

    public function getAssociatedFile()
    {
        return $this->belongsTo(FileUpload::class);
    }
}
