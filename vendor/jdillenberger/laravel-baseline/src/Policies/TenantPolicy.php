<?php

namespace Jdillenberger\LaravelBaseline\Policies;

use \Jdillenberger\LaravelBaseline\Models\Tenant;
use \Jdillenberger\LaravelBaseline\Models\User;


class TenantPolicy
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
    public function single(?User $user, Tenant $organization): bool
    {
        return true || $this->list($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Tenant $organization): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Tenant $organization): bool
    {
        return true;
    }
}
