<?php

namespace App\Actions\Auth;

use App\Models\IpAdress;
use App\Models\Session;
use App\Models\SessionAccessToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthenticateRedirectUrl
{
    public static function getRedirectUrl(Request $request, string $redirectUrl): ?string
    {
        $urlHost = parse_url($redirectUrl, PHP_URL_HOST);

        if (in_array($urlHost, config("app.domain"))) {
            $request->session()->save();
            $sessionAccessToken = new SessionAccessToken([
                'session_id' => $request->session()->getId(),
                'expires_at' => Carbon::now()->addMinutes(5),
            ]);
            $sessionAccessToken->generateToken();
            $sessionAccessToken->save();

            // We will add the token to the redirect url parameters
            $newRedirectUrl = $redirectUrl . (parse_url($redirectUrl, PHP_URL_QUERY) ? '&' : '?') . 'session_access_token=' . $sessionAccessToken->token;
            return $newRedirectUrl;
        } else {
            return null;
        }
    }
}
