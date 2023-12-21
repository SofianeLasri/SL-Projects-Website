<?php

namespace App\Http\Middleware;

use App\Jobs\SaveRequestJob;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SaveRequestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
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
        SaveRequestJob::dispatch($serializedRequest);
    }
}
