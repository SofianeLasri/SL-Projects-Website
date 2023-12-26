<?php

namespace App\Http\Middleware;

use App\Jobs\SaveRequestsJob;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class SaveRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        $uniqueId = uniqid();
        $cacheKey = "request_{$uniqueId}";

        $serializedRequest = [
            'ip' => $request->ip(),
            'country_code' => $request->header('CF-IPCountry'),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_agent' => $request->header('User-Agent'),
            'referer' => $request->header('referer'),
            'origin' => $request->header('origin'),
            'content_type' => $request->header('content-type'),
            'content_length' => $request->header('content-length'),
            'status_code' => $response->getStatusCode(),
            'user_id' => $request->user()?->id,
        ];

        Cache::remember($cacheKey, 60 * 24, function () use ($serializedRequest) {
            return $serializedRequest;
        });

        $requests = Cache::get('requests', []);
        $requests[] = $cacheKey;
        Cache::put('requests', $requests, 60 * 24);
    }
}
