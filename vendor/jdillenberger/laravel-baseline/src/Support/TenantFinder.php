<?php

namespace Jdillenberger\LaravelBaseline\Support;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Contracts\IsTenant;

class TenantFinder extends \Spatie\Multitenancy\TenantFinder\TenantFinder
{
    public function findForRequest(Request $request): ?IsTenant
    {
        $prefix = $request->segment(1) !== 'api' ? $request->segment(1) : $request->segment(2);

        $tenantClass = getBaselineTenantModel();

        return $tenantClass::where([
            'prefix' => $prefix,
        ])->first();
    }
}
