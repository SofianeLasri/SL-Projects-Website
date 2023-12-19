<?php

namespace App\Jobs;

use App\Models\FileUpload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ConvertImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected BelongsTo|FileUpload $fileUpload;

    protected string $conversionType;

    public function __construct(BelongsTo|FileUpload $fileUpload, $conversionType)
    {
        $this->fileUpload = $fileUpload;
        $this->conversionType = $conversionType;
    }

    public function handle(): void
    {
        Log::debug('Converting image '.$this->fileUpload->filename.' to '.$this->conversionType);
        $this->fileUpload->convertImage($this->conversionType);
    }
}
