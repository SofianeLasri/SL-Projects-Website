<?php

namespace App\Console\Commands;

use App\Jobs\ConvertImageJob;
use App\Models\PendingImageConversion;
use Illuminate\Console\Command;

class ConvertImagesCommand extends Command
{
    protected $signature = 'convert:images';

    protected $description = 'Run pending image conversions';

    public function handle(): void
    {
        $imagesToConvert = PendingImageConversion::get();

        foreach ($imagesToConvert as $image) {
            ConvertImageJob::dispatch($image->fileUpload, $image->type);
        }
    }
}
