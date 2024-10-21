<?php

namespace Jdillenberger\LaravelBaseline\Models\Traits;

trait ScopesTenant
{
    use \Spatie\Multitenancy\Commands\Concerns\TenantAware;

    public static function bootScopesTenant()
    {
        static::creating(function ($model) {
            if (! array_key_exists('tenant_id', $model->attributes)) {
                $model->attributes['tenant_id'] = app('currentTenant')->id;
            }
        });

        static::addGlobalScope(new \Jdillenberger\LaravelBaseline\Scopes\TenantScope);
    }
}
