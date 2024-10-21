<?php

namespace App\Services\Adfrodite\Controllers;

use Illuminate\Http\Request;

/**
 * @group Ad Campaigns
 */
class AdCampaignsController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * List Campaigns
     *
     * @authenticated
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function list()
    {
        return $this->defaultList(\Jdillenberger\LaravelAds\Models\AdCampaign::class);
    }

    /**
     * Create Campaign
     *
     * @authenticated
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     *
     * @bodyParam name string Name for the Campaign Example: Example Campaign
     * @bodyParam budget integer Name for the Campaign Example: 1000
     * @bodyParam start_date string When does the campaign start? Example: 2023-10-14
     * @bodyParam end_date string When does the campaign end? Example: 2032-10-14
     * @bodyParam status string Is the campaign active, paused, draft or compleded. Example: draft
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'budget' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'status' => ['required', 'in:active,paused,draft,completed'],
        ]);

        $this->defaultCreate(\Jdillenberger\LaravelAds\Models\AdCampaign::class, $data);
    }

    /**
     * Single Campaign
     *
     * @authenticated
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     *
     * @pathParam campaign integer Id of the Campaign. Example: 1
     */
    public function single(\Jdillenberger\LaravelAds\Models\AdCampaign $campaign)
    {
        return $this->defaultSingle($campaign);
    }

    /**
     * Update Campaign
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam campaign integer Id of the Campaign. Example: 1
     *
     * @bodyParam name string Name for the Campaign Example: Example Campaign
     * @bodyParam budget integer Name for the Campaign Example: 1000
     * @bodyParam start_date string When does the campaign start? Example: 2023-10-14
     * @bodyParam end_date string When does the campaign end? Example: 2032-10-14
     * @bodyParam status string Is the campaign active, paused, draft or compleded? Example: draft
     */
    public function update(Request $request, \Jdillenberger\LaravelAds\Models\AdCampaign $campaign)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'budget' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'status' => ['required', 'in:active,paused,draft,completed'],
        ]);

        return $this->defaultUpdate($campaign, $data);
    }

    /**
     * Delete Campaign
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam campaign integer Id of the Campaign. Example: 1
     */
    public function delete(Request $request, \Jdillenberger\LaravelAds\Models\AdCampaign $campaign)
    {
        return $this->defaultDelete($campaign);
    }
}
