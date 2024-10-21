<?php

namespace Jdillenberger\LaravelBaseline\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ManyTenantsScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (app('currentTenant')->id !== 1) {
            $currentTenantId = app('currentTenant')->id;

            $builder->whereHas('tenants', function ($query) use ($currentTenantId) {
                $query->where('tenant_user.tenant_id', $currentTenantId);
            });            
        } 
    }
}
