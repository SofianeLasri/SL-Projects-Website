<?php

namespace App\Jobs;

use App\Models\Request as RequestModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SaveRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private RequestModel $request;

    public function __construct(RequestModel $request)
    {
        $this->request = $request;
        Log::debug("Cstrct Saving request {$this->request}");
    }

    public function handle(): void
    {
        Log::debug("Saving request {$this->request}");
        $this->request->save();
    }
}
