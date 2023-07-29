<?php

namespace App\Actions\Auth;

use App\Models\SessionAccessToken;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application as ContractsFoundationApplication;
use Illuminate\Foundation\Application as FoundationApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Spatie\Url\Url;

class CustomAuth
{
    /**
     * Permet la création d'un token de session à usage unique pour la connexion à un site interne.
     * Redirige vers l'url donnée avec le token en paramètre.
     * @param Request $request
     * @param string $redirectUrl
     * @return FoundationApplication|Redirector|RedirectResponse|ContractsFoundationApplication
     */
    public static function authenticateOnRedirectedUrl(Request $request, string $redirectUrl): FoundationApplication|Redirector|RedirectResponse|ContractsFoundationApplication
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

        $newRedirectUrl = Url::fromString($redirectUrl)->withQueryParameter('session_access_token', $sessionAccessToken->token);
        return redirect($newRedirectUrl);
    }

    /**
     * Vérifie que le domaine de redirection est bien dans la liste des domaines du site.
     * Pas de OAuth2 pour l'instant.
     * @param string $redirectUrl Url à vérifier
     * @return bool
     */
    public static function isTrustedUrl(string $redirectUrl): bool
    {
        $parsedUrl = Url::fromString($redirectUrl);
        $urlHost = $parsedUrl->getHost();

        if (in_array($urlHost, config("app.domain"))) {
            return true;
        } else {
            return false;
        }
    }
}
