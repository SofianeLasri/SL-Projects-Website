<?php

namespace App\Http\Middleware;

use App\Models\IpAdress;
use App\Models\UserIpAddress;
use Closure;
use App\Models\Request as RequestModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveRequestMiddleware
{
    private RequestModel $savedRequest;

    public function handle(Request $request, Closure $next)
    {
        $savedIp = IpAdress::firstOrCreate([
            "ip" => $request->ip()
        ]);

        $this->savedRequest = new RequestModel([
            "ip_adress_id" => $savedIp->id,
            "country_code" => $request->header('CF-IPCountry'),
            "url" => $request->url(),
            "method" => $request->method(),
            "user_agent" => $request->header('User-Agent'),
            "referer" => $request->header('referer'),
            "origin" => $request->header('origin'),
            "content_type" => $request->header('content-type'),
            "content_length" => $request->header('content-length'),
            "user_id" => $request->user()?->id
        ]);
        $this->savedRequest->save();

        // Si l'utilisateur est connecté
        if ($request->user()) {
            $userIdAdress = new UserIpAddress([
                "user_id" => $request->user()->id,
                "ip_adress_id" => $savedIp->id,
            ]);
            $userIdAdress->save();
        }

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        $this->savedRequest->status_code = $response->getStatusCode();
        $this->savedRequest->save();
    }
}
