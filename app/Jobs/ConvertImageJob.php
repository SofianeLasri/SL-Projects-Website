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
            Log::debug('Converting image '.$image->fileUpload->filename.' to '.$image->type);
            $image->fileUpload->convertImage($image->type);
        }
    }
}
