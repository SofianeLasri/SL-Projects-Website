<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendingImageConversion extends Model
{
    protected $connection = 'main';

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';

    protected $fillable = [
        'file_upload_id',
        'type',
    ];

    public function fileUpload(): BelongsTo
    {
        return $this->belongsTo(FileUpload::class);
    }

    public static function getAllPendingAndMarkAsProcessing(): Collection
    {
        $pending = self::where('status', self::STATUS_PENDING)->get();
        self::whereIn('id', $pending->pluck('id'))->update(['status' => self::STATUS_PROCESSING]);
        return $pending;
    }
}
