<?php

namespace Jdillenberger\LaravelBaseline\Controllers;

use \Jdillenberger\LaravelBaseline\Models\Tenant;
use Illuminate\Http\Request;

/**
 * @group Tenants
 */
class TenantsController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * List Tenants
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function list(Request $request)
    {
        return $this->defaultList(\Jdillenberger\LaravelBaseline\Models\Tenant::class);
    }

    /**
     * Current Tenant
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function current(Request $request)
    {
        return $this->single($request, app('currentTenant'));
    }

    /**
     * Single Tenant
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam tenant integer Id of the Tenant. Example: 1
     */
    public function single(Request $request, Tenant $tenant)
    {
        return $this->defaultSingle($tenant);
    }

    /**
     * Create Tenant
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * 
     * @bodyParam name string The Name of the Tenant Example: Wikipedia
     * @bodyParam domain string Domain for the Tenant. Used for Tenant Identification. Example: domain.tld
     * @bodyParam prefix string Path-Prefix for the Tenant. Used for Tenant Identification. Example: organization1
     * @bodyParam force_port int Port where this organization can be served. Example: organization1
     */
    public function create(Request $request)
    {
        return $this->defaultCreate(\Jdillenberger\LaravelBaseline\Models\Tenant::class, $request->all());
    }

    /**
     * Update Tenant
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam tenant integer Id of the Tenant. Example: 1
     *
     * @bodyParam name string The Name of the Tenant Example: Wikipedia
     * @bodyParam domain string Domain for the Tenant. Used for Tenant Identification. Example: domain.tld
     * @bodyParam prefix string Path-Prefix for the Tenant. Used for Tenant Identification. Example: organization1
     * @bodyParam force_port int Port where this organization can be served. Example: organization1
     */
    public function update(Request $request, Tenant $tenant)
    {
        return $this->defaultUpdate($tenant, $request->all());
    }

    /**
     * Delete Tenant
     *
     * @authenticated
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     *
     * @pathParam tenant integer Id of the Tenant. Example: 1
     */
    public function delete(Request $request, Tenant $tenant)
    {
        return $this->defaultDelete($tenant);
    }
}
