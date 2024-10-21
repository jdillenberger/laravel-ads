<?php

namespace Jdillenberger\LaravelBaseline\Controllers;

use Illuminate\Http\Request;

/**
 * @group Users
 */
class UsersController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * List Users
     *
     * @authenticated
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     * 
     */
    public function list(Request $request)
    {
        return $this->defaultList(getBaselineUserModel());
    }

    /**
     * Single User
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam user integer Id of the User. Example: 1
     */
    public function single(Request $request, \Jdillenberger\LaravelBaseline\Models\User $user)
    {
        return $this->defaultSingle($user);
    }

    /**
     * Create User
     *
     * @authenticated
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function create(Request $request)
    {
        return $this->defaultCreate(\Jdillenberger\LaravelBaseline\Models\User::class, $request->all());
    }

    /**
     * Update User
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam user integer Id of the User. Example: 1
     */
    public function update(Request $request, \Jdillenberger\LaravelBaseline\Models\User $user)
    {
        return $this->defaultUpdate($user, $request->all());

    }

    /**
     * Delete User
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam user integer Id of the User. Example: 1
     */
    public function delete(\Jdillenberger\LaravelBaseline\Models\User $user)
    {
        return $this->defaultDelete($user);
    }

    /**
     * Upload User Avatar
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam user integer Id of the User. Example: 1
     *
     * @bodyParam avatar string required Base64 encoded Image Example: data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==
     */
    public function uploadAvatar(Request $request, \Jdillenberger\LaravelBaseline\Models\User $user)
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
        }

        if (is_string($request->avatar) && \Illuminate\Support\Str::startsWith($request->avatar, ['data:'])) {
            $avatar = $request->avatar;
        }

        $user->update([
            'avatar' => $avatar,
        ]);

        return $this->successResourceCreated();
    }

    /**
     * Show User Avatar
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam user integer Id of the User. Example: 1
     */
    public function showAvatar(Request $request, \Jdillenberger\LaravelBaseline\Models\User $user)
    {
        return $user->avatar;
    }
}
