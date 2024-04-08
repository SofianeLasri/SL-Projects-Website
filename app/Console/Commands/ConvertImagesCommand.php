<?php

namespace App\Console\Commands;

use App\Jobs\ConvertImageJob;
use App\Models\PendingImageConversion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class ConvertImagesCommand extends Command
{
    protected $signature = 'convert:images';

    protected $description = 'Run pending image conversions';

    public function handle(): void
    {
        $imagesToConvert = PendingImageConversion::getAllPendingAndMarkAsProcessing();
        $count = count($imagesToConvert);

        if ($count > 0) {
            $this->info("Starting to convert $count images");

            foreach ($imagesToConvert as $image) {
                Bus::dispatchSync(new ConvertImageJob($image));
            }
        }
    }
}
