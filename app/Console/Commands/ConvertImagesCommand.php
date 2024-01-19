<?php

namespace App\Console\Commands;

use App\Jobs\ConvertImageJob;
use App\Models\PendingImageConversion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ConvertImagesCommand extends Command
{
    protected $signature = 'convert:images';

    protected $description = 'Run pending image conversions';

    public function handle(): void
    {
        $imagesToConvert = PendingImageConversion::getAllPendingAndMarkAsProcessing();
        $count = count($imagesToConvert);

        $this->info("Starting to convert $count images");

        Bus::chain(
            collect($imagesToConvert)->map(function (PendingImageConversion $imageToConvert) {
                return new ConvertImageJob($imageToConvert);
            })
        )->dispatch();
    }
}
