<?php

namespace Jdillenberger\LaravelBaseline\Policies;

class TagPolicy extends \Jdillenberger\LaravelBaseline\Foundation\Policy
{
    /**
     * Determine whether the user can view any models.
     */
    public function list(?\Jdillenberger\LaravelBaseline\Models\User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function single(?\Jdillenberger\LaravelBaseline\Models\User $user, \Jdillenberger\LaravelBaseline\Models\Tag $tag): bool
    {
        return true || $this->list($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?\Jdillenberger\LaravelBaseline\Models\User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?\Jdillenberger\LaravelBaseline\Models\User $user, \Jdillenberger\LaravelBaseline\Models\Tag $tag): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?\Jdillenberger\LaravelBaseline\Models\User $user, \Jdillenberger\LaravelBaseline\Models\Tag $tag): bool
    {
        return true;
    }
}
