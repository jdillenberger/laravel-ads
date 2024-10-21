<?php

namespace App\Services\Adfrodite\Controllers;

/**
 * @group Ad Placements
 */
class AdPlacementsController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * List Placements
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     */
    public function list(\Jdillenberger\LaravelAds\Models\AdCampaign $campaign)
    {
        return $this->defaultList(\Jdillenberger\LaravelAds\Models\AdPlacement::class);
    }

    /**
     * Create PLacement
     *
     * @authenticated
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     *
     * @bodyParam name string Name for the Campaign Example: Index footer banner
     * @bodyParam description string Description where to find the Placement. Example: In the footer of the index-page.
     * @bodyParam location string String that identifies the locaion of the ad-block on the website Example: index-footer-banner
     * @bodyParam width integer Suggested width of an advertisement in that position. Example: 400
     * @bodyParam height integer Suggested width of an advertisement in that position. Example: 150
     */
    public function create(\Jdillenberger\LaravelAds\Models\AdCampaign $campaign)
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string',
            'width' => 'required|integer',
            'height' => 'required|integer',
        ]);

        return $this->defaultCreate(\Jdillenberger\LaravelAds\Models\AdPlacement::class, $data);
    }

    /**
     * Single Placement
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam placement integer Id of the Placement. Example: 1
     */
    public function single(\Jdillenberger\LaravelAds\Models\AdCampaign $campaign, \Jdillenberger\LaravelAds\Models\AdPlacement $placement)
    {
        return $this->defaultSingle($placement);
    }

    /**
     * Update PLacement
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam placement integer Id of the Placement. Example: 1
     *
     * @bodyParam name string Name for the Placement Example: Index footer banner
     * @bodyParam description string Description where to find the Placement. Example: In the footer of the index-page.
     * @bodyParam location string String that identifies the locaion of the ad-block on the website Example: index-footer-banner
     * @bodyParam width integer Suggested width of an advertisement in that position. Example: 400
     * @bodyParam height integer Suggested width of an advertisement in that position. Example: 150
     */
    public function update(\Jdillenberger\LaravelAds\Models\AdCampaign $campaign, \Jdillenberger\LaravelAds\Models\AdPlacement $placement)
    {
        $data = request()->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'sometimes|required|string',
            'width' => 'sometimes|required|integer',
            'height' => 'sometimes|required|integer',
        ]);

        return $this->defaultUpdate($placement, $data);
    }

    /**
     * Delete Placement
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam placement integer Id of the Placement. Example: 1
     */
    public function delete(\Jdillenberger\LaravelAds\Models\AdCampaign $campaign, \Jdillenberger\LaravelAds\Models\AdPlacement $placement)
    {
        return $this->defaultDelete($placement);
    }
}
