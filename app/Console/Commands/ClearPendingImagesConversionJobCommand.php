<?php

namespace App\Console\Commands;

use App\Models\PendingImageConversion;
use Illuminate\Console\Command;

class ClearPendingImagesConversionJobCommand extends Command
{
    protected $signature = 'clear:pending-images-conversion-job';

    protected $description = 'Clear pending images conversion job';

    public function handle(): void
    {
        PendingImageConversion::truncate();
        $this->info('Pending images conversion job cleared!');
    }
}
