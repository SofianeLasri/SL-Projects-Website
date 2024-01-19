<?php

namespace App\Jobs;

use App\Models\FileUpload;
use App\Models\PendingImageConversion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ConvertImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PendingImageConversion $imageToConvert;

    public function __construct(PendingImageConversion $imageToConvert)
    {
        $this->imageToConvert = $imageToConvert;
    }

    public function handle(): void
    {
        $this->imageToConvert->fileUpload->convertImage($this->imageToConvert->type);
    }
}
