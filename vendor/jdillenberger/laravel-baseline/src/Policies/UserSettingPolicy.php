<?php

namespace Jdillenberger\LaravelBaseline\Policies;

use \Jdillenberger\LaravelBaseline\Models\User;
use \Jdillenberger\LaravelBaseline\Models\UserSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserSettingPolicy
{
    use \Illuminate\Auth\Access\HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function list(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function single(?User $user, UserSetting $setting): bool
    {
        return $user->id === $setting->meta_id && $user::class === $setting->meta_type;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserSetting $setting): bool
    {
        return $user->id === $setting->meta_id && $user::class === $setting->meta_type;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, UserSetting $setting): bool
    {
        return true; $user->id === $setting->meta_id && $user::class === $setting->meta_type;
    }
}
