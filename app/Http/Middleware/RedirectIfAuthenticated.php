<?php

namespace App\Http\Middleware;

use App\Actions\Auth\AuthenticateRedirectUrl;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @param string|null ...$guards
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards): Response|RedirectResponse
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (!empty($request->input('redirect'))) {
                    $redirectUrl = AuthenticateRedirectUrl::getRedirectUrl($request, $request->input('redirect'));

                    if ($redirectUrl != null) {
                        return redirect($redirectUrl);
                    } else {
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
                } else {
                    return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}
