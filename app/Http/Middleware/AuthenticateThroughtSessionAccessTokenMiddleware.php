<?php

namespace App\Http\Middleware;

use App\Models\SessionAccessToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Spatie\Url\Url;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ici nous vérifions la présence d'un token d'accès de session dans l'url, connectons l'utilisateur si c'est ok
 * et le redirigons vers la page de login s'il n'est pas connecté.
 */
class AuthenticateThroughtSessionAccessTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('session_access_token')) {
            $sessionAccessToken = SessionAccessToken::where('token', $request->input('session_access_token'))
                ->where('expires_at', '>=', Carbon::now())
                ->first();

            if ($sessionAccessToken !== null) {
                $storedSession = $sessionAccessToken->session;
                if ($storedSession->user_agent == $request->userAgent() && $storedSession->ip_address === $request->ip()) {
                    $sessionAccessToken->expires_at = Carbon::now();
                    $sessionAccessToken->save();

                    $request->session()->setId($storedSession->id);
                    $request->session()->start();

                    // We remove the session_access_token from the url
                    $url = $request->fullUrl();
                    $url = Url::fromString($url)->withoutQueryParameter('session_access_token');
                    return redirect($url);
                }
            }
        }

        if (!$request->user()) {
            return redirect(route('login', ['redirect' => $request->fullUrl()]));
        }
        return $next($request);
    }
}
