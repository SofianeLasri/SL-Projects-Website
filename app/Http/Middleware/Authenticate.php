<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as AuthMiddleware;
use Illuminate\Http\Request;

class Authenticate extends AuthMiddleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            return route('login', ['redirect' => $request->fullUrl()]);
        }
        return null;
    }
}
