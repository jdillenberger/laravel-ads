<?php

namespace Jdillenberger\LaravelBaseline\Controllers;

use Illuminate\Http\Request;

/**
 * @group User Settings
 */
class UserSettingsController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * List User Settings
     *
     * @authenticated
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function list(Request $request, \Jdillenberger\LaravelBaseline\Models\User $user)
    {
        return $this->defaultList(\Jdillenberger\LaravelBaseline\Models\UserSetting::class, [
            'meta_id' => $user->id,
            'meta_type' => $user::class,
        ]);
    }

    /**
     * Single User Setting
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam user integer Id of the User. Example: 1
     */
    public function single(Request $request, \Jdillenberger\LaravelBaseline\Models\User $user, \Jdillenberger\LaravelBaseline\Models\UserSetting $setting)
    {
        if (! $user->hasSetting($setting)) {
            abort(404);
        }

        return $this->defaultSingle($user);
    }

    /**
     * Create Setting
     *
     * @authenticated
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function create(Request $request, \Jdillenberger\LaravelBaseline\Models\User $user)
    {
        return $this->defaultCreate(\Jdillenberger\LaravelBaseline\Models\UserSetting::class, array_merge($request->all(), [
            'meta_id' => $user->id,
            'meta_type' => $user::class,
        ]));
    }

    /**
     * Update User
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam user integer Id of the User. Example: 1
     *
     * @bodyParam key string Identifier for the setting Example: darkmode
     * @bodyParam string object The setting to save Example: true
     */
    public function update(Request $request, \Jdillenberger\LaravelBaseline\Models\User $user, \Jdillenberger\LaravelBaseline\Models\UserSetting $setting)
    {
        if (! $user->hasSetting($setting)) {
            abort(404);
        }

        return $this->defaultUpdate($setting, $request->all());
    }

    /**
     * Delete User
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam user integer Id of the User. Example: 1
     */
    public function delete(\Jdillenberger\LaravelBaseline\Models\User $user, \Jdillenberger\LaravelBaseline\Models\UserSetting $setting)
    {
        if (! $user->hasSetting($setting)) {
            abort(404);
        }

        return $this->defaultDelete($setting);
    }
}
