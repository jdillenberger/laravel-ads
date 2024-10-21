<?php

namespace Jdillenberger\LaravelBaseline\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Index
 */
class IndexController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * Show Info
     */
    public function index(Request $request)
    {
        $hide = ['domain', 'prefix', 'force_port', 'created_at', 'updated_at', 'deleted_at'];
        $show = ['docs'];

        return $this->success(__('success:index_fetched'), data: [
            'documentation' => url('/'.config('idoc.path')),
            'current_tenant' => app('currentTenant')->makeHidden($hide)->makeVisible($show),
            'user' => Auth::user() ?? null,
        ]);
    }

    /**
     * Enable Tenant
     *
     * Use this route if you already have a token, which is not valid for the current tenant.
     * This will connect the user account with the current tenant, validates the users login for the tenant.
     */
    public function enableTenant(Request $request)
    {
        $token = $request->bearerToken();

        $user = $this->getSanctumUser($token);

        if (! $user) {
            $user = $this->getImpersonateUser($token);
        }

        if (! $user) {
            return $this->error('exception:user_not_found');
        }

        if (Auth::id() === $user->id && env('APP_ENV') !== 'documentation') {
            return $this->error('exception:user_already_uses_tenant');
        }

        $user->tenants()->attach(app('currentTenant'));

        return $this->successResourceCreated();
    }

    private function getSanctumUser($bearerToken)
    {
        if (is_null($bearerToken)) {
            return null;
        }

        $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($bearerToken ?? '');

        return getBaselineUserModel()::withoutGlobalScopes()->find($accessToken->tokenable_id ?? null);
    }

    private function getImpersonateUser($bearerToken)
    {
        if (is_null($bearerToken)) {
            return null;
        }

        $user_id = \Illuminate\Support\Facades\Cache::get('impersonate-'.$bearerToken, null);

        if (! is_null($user_id)) {
            return getBaselineUserModel()::withoutGlobalScopes()->find($user_id);
        }

        return null;
    }
}
