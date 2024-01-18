<?php

namespace App\Jobs;

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

    public function __construct()
    {
    }

    public function handle(): void
    {
        $imagesToConvert = PendingImageConversion::get();
        foreach ($imagesToConvert as $image) {
            $image->fileUpload->convertImage($image->type);
        }
    }
}
