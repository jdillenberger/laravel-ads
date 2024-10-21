<?php

namespace Jdillenberger\LaravelBaseline\Middleware;


/**
 * Middleware to enforce user in develpment mode, if development token is provided.
 */
class ImpersonateTokenAuth
{
    public function handle(\Illuminate\Http\Request $request, \Closure $next)
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            return $next($request);
        }

        return $this->autoLogin($request, $next);
    }

    public function autoLogin(\Illuminate\Http\Request $request, \Closure $next)
    {
        $user_id = \Illuminate\Support\Facades\Cache::get('impersonate-'.$request->bearerToken(), null);
        $userClass = config('models.default_user', getBaselineUserModel());

        if (is_null($user_id)) {
            return $next($request);
        }

        $user = $userClass::find($user_id);

        if ($user !== null) {
            \Illuminate\Support\Facades\Auth::setUser($user);
        }

        return $next($request);
    }
}
