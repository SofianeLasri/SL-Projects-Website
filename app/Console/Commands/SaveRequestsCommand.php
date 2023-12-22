<?php

namespace App\Console\Commands;

use App\Jobs\SaveRequestsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SaveRequestsCommand extends Command
{
    protected $signature = 'save:requests';

    protected $description = 'Save pending requests to database';

    public function handle(): void
    {
        $requestsIndexes = Cache::get('requests', []);
        Cache::forget('requests');
        $this->info('Saving '.count($requestsIndexes).' requests');

        $requests = [];
        foreach ($requestsIndexes as $requestIndex) {
            $tempReq = Cache::get("{$requestIndex}");
            $requests[] = $tempReq;
            Cache::forget("{$requestIndex}");
        }

        SaveRequestsJob::dispatch($requests);
    }
}
