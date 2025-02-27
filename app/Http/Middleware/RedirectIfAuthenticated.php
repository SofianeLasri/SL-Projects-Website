<?php

namespace App\Http\Middleware;

use App\Actions\Auth\CustomAuth;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @param  string|null  ...$guards
     */
    public function handle(Request $request, Closure $next, ...$guards): Response|RedirectResponse
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (empty($request->input('redirect'))) {
                    return redirect(RouteServiceProvider::HOME);
                }

                return CustomAuth::authenticateOnRedirectedUrl($request, $request->input('redirect'));
            }
        }

        return $next($request);
    }
}
