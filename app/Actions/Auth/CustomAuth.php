<?php

namespace App\Actions\Auth;

use App\Models\IpAdress;
use App\Models\Session;
use App\Models\SessionAccessToken;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Spatie\Url\Url;

class CustomAuth
{
    /**
     * Permet la création d'un token de session à usage unique pour la connexion à un site interne.
     * Redirige vers l'url donnée avec le token en paramètre.
     * @param Request $request
     * @param string $redirectUrl
     * @return Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public static function authenticateOnRedirectedUrl(Request $request, string $redirectUrl): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (!self::isTrustedUrl($redirectUrl)) {
            Auth::logout();

            $request->session()->flash(
                'errors',
                new MessageBag([
                    'redirect' => trans(
                        'validation.allowed_redirect_url',
                        [
                            'redirect' => $request->input('redirect')
                        ]
                    )
                ])
            );
            return redirect()->route('login');
        }

        // On enregistre la session dans la base de données
        $request->session()->save();

        // On annule les tokens de session précédents
        SessionAccessToken::cancelAllActiveTokensForUser($request->user());

        // On créé un token d'accès à usage unique pour la session
        $sessionAccessToken = new SessionAccessToken([
            'session_id' => $request->session()->getId(),
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // On génère le token unique
        $sessionAccessToken->generateToken();
        $sessionAccessToken->save();

        $newRedirectUrl = Url::fromString($redirectUrl);
        $newRedirectUrl->withQueryParameter('session_access_token', $sessionAccessToken->token);

        return redirect($newRedirectUrl);
    }

    public static function isTrustedUrl(string $redirectUrl): bool
    {
        $parsedUrl = Url::fromString($redirectUrl);
        $urlHost = $parsedUrl->getHost();

        // On vérifie que le domaine de redirection est bien dans la liste des domaines du site
        // Pas de OAuth2 pour l'instant
        if (in_array($urlHost, config("app.domain"))) {
            return true;
        } else {
            return false;
        }
    }
}
