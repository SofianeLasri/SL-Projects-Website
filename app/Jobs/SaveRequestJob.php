<?php

namespace App\Jobs;

use App\Models\IpAdress;
use App\Models\MimeType;
use App\Models\Request as RequestModel;
use App\Models\Url;
use App\Models\UserAgent;
use App\Models\UserIpAddress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SaveRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $request;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function handle(): void
    {
        $createdRequestEntry = RequestModel::create([
            'ip_adress_id' => IpAdress::getIdFromCacheOrCreate($this->request['ip']),
            'country_code' => $this->request['country_code'],
            'url_id' => Url::firstOrCreate(['url' => $this->request['url']])->id,
            'method' => $this->request['method'],
            'user_agent_id' => ! empty($this->request['user_agent']) ? UserAgent::getIdFromCacheOrCreate($this->request['user_agent']) : null,
            'referer_url_id' => ! empty($this->request['referer']) ? Url::getIdFromCacheOrCreate($this->request['referer']) : null,
            'origin_url_id' => ! empty($this->request['origin']) ? Url::getIdFromCacheOrCreate($this->request['origin']) : null,
            'content_type_mime_type_id' => ! empty($this->request['content_type']) ? MimeType::getIdFromCacheOrCreate($this->request['content_type']) : null,
            'content_length' => $this->request['content_length'],
            'status_code' => $this->request['status_code'],
            'user_id' => $this->request['user_id'],
        ]);

        // Si l'utilisateur est connecté
        if (! empty($this->request['user_id'])) {
            UserIpAddress::create([
                'user_id' => $this->request['user_id'],
                'ip_adress_id' => $createdRequestEntry->ip_adress_id,
            ]);
        }
    }
}
