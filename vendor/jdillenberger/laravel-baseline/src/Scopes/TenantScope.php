<?php

namespace Jdillenberger\LaravelBaseline\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (app('currentTenant')->id !== 1) {
            $builder->where('tenant_id', app('currentTenant')->id);
        }
    }
}
