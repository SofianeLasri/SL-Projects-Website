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

    public const TYPE_THUMBNAIL = 'thumbnail';

    public const TYPE_SMALL = 'small';

    public const TYPE_MEDIUM = 'medium';

    public const TYPE_LARGE = 'large';

    public const TYPE_ORIGINAL = 'original';

    public function associatedFile(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class, 'file_upload_id');
    }

    public function getOriginalFile(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class, 'original_file_upload_id');
    }

    public function scopeThumbnail($query)
    {
        return $query->where($this->getTable().'.type', self::TYPE_THUMBNAIL);
    }

    public function scopeSmall($query)
    {
        return $query->where($this->getTable().'.type', self::TYPE_SMALL);
    }

    public function scopeMedium($query)
    {
        return $query->where($this->getTable().'.type', self::TYPE_MEDIUM);
    }

    public function scopeLarge($query)
    {
        return $query->where($this->getTable().'.type', self::TYPE_LARGE);
    }
}
