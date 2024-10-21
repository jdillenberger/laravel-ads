<?php

namespace Jdillenberger\LaravelBaseline\Models\Traits;

trait ScopesManyTenants
{
    use \Spatie\Multitenancy\Commands\Concerns\TenantAware;

    public static function bootScopesManyTenants()
    {

        $tenantClass = getBaselineTenantModel();

        static::created(function ($model) use ($tenantClass) {

            $tenant = $tenantClass::current() ?? null;

            if (config('app.is_seeding', false) && $tenant === null) {
                $model->tenants()->attach($tenantClass::all());
            } else {
                $model->tenants()->attach($tenant);
            }
        });

        static::addGlobalScope(new \Jdillenberger\LaravelBaseline\Scopes\ManyTenantsScope);
    }

    public function tenants()
    {
        $pivotPart = \Illuminate\Support\Str::singular($this->getTable());

        return $this->belongsToMany(getBaselineTenantModel(), "tenant_{$pivotPart}", "{$pivotPart}_id", 'tenant_id');
    }
}
