<?php

namespace Jdillenberger\LaravelBaseline\Middleware;

class TokenAuthentification
{
    public function handle(\Illuminate\Http\Request $request, \Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($request->bearerToken() ?? '');

        if ($accessToken && $accessToken->tokenable instanceof \Jdillenberger\LaravelBaseline\Models\User) {

            \Illuminate\Support\Facades\Auth::login($accessToken->tokenable);
        }

        return $next($request);
    }
}
