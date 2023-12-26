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
class SaveRequestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $requests;

    public function __construct(array $requests)
    {
        $this->requests = $requests;
    }

    public function handle(): void
    {
        $requestsToInsert = [];
        $userIpAddressesToInsert = [];

        foreach ($this->requests as $request) {
            $requestsToInsert[] = [
                'ip_adress_id' => IpAdress::getIdFromCacheOrCreate($request['ip']),
                'country_code' => $request['country_code'],
                'url_id' => Url::firstOrCreate(['url' => $request['url']])->id,
                'method' => $request['method'],
                'user_agent_id' => ! empty($request['user_agent']) ? UserAgent::getIdFromCacheOrCreate($request['user_agent']) : null,
                'referer_url_id' => ! empty($request['referer']) ? Url::getIdFromCacheOrCreate($request['referer']) : null,
                'origin_url_id' => ! empty($request['origin']) ? Url::getIdFromCacheOrCreate($request['origin']) : null,
                'content_type_mime_type_id' => ! empty($request['content_type']) ? MimeType::getIdFromCacheOrCreate($request['content_type']) : null,
                'content_length' => $request['content_length'],
                'status_code' => $request['status_code'],
                'user_id' => $request['user_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Si l'utilisateur est connecté
            if (! empty($request['user_id'])) {
                $userIpAddressesToInsert[] = [
                    'user_id' => $request['user_id'],
                    'ip_adress_id' => IpAdress::getIdFromCacheOrCreate($request['ip']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        RequestModel::insert($requestsToInsert);
        UserIpAddress::insert($userIpAddressesToInsert);
    }
}
