<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendingImageConversion extends Model
{
    protected $fillable = [
        'file_upload_id',
        'type',
    ];

    public function fileUpload(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class);
    }
}
