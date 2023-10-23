<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PictureType extends Model
{
    protected $connection = 'main';

    protected $fillable = [
        'file_upload_id',
        'original_file_upload_id',
        'type',
    ];

    public function associatedFile(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class, 'file_upload_id');
    }

    public function getOriginalFile(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class, 'original_file_upload_id');
    }
}
