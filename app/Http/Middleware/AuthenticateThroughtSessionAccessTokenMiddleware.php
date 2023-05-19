<?php

namespace App\Http\Middleware;

use App\Models\SessionAccessToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthenticateThroughtSessionAccessTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('session_access_token')) {
            $sessionAccessToken = SessionAccessToken::where('token', $request->input('session_access_token'))
                ->where('expires_at', '>=', Carbon::now())
                ->first();

            if ($sessionAccessToken) {
                $storedSession = $sessionAccessToken->session;
                if ($storedSession->user_agent == $request->userAgent() && $storedSession->ip_address === $request->ip()) {
                    $sessionAccessToken->expires_at = Carbon::now();
                    $sessionAccessToken->save();

                    $request->session()->setId($storedSession->id);
                    $request->session()->start();

                    // We remove the session_access_token from the url
                    $url = $request->fullUrl();
                    $url = Str::replace('session_access_token=' . $request->input('session_access_token'),
                        '', $url);

                    return redirect($url);
                }
            }
        }
        return $next($request);
    }
}
