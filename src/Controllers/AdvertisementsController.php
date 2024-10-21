<?php

namespace App\Services\Adfrodite\Controllers;

use Jdillenberger\LaravelAds\Models\AdCampaign;
use Jdillenberger\LaravelAds\Models\Advertisement;
use Illuminate\Http\Request;

/**
 * @group Advertisements
 */
class AdvertisementsController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * List Advertisements
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam campaign integer Id of the Campaign. Example: 1
     */
    public function list(AdCampaign $campaign)
    {
        \Illuminate\Support\Facades\Gate::authorize('list', \Jdillenberger\LaravelAds\Models\Advertisement::class);

        $pager = $campaign->advertisements()->paginate();

        return $this->successResourceFetched([
            'pagination' => $this->pagerMeta($pager),
            'advertisements' => $pager->items(),
        ]);
    }

    /**
     * Create Advertisement
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam campaign integer Id of the Campaign. Example: 1
     *
     * @bodyParam title string Title for the Ad. Example: Best ad from our business partner
     * @bodyParam link string The Url a user is redirected to, if the user interacts with the advertisement. Example: https://example.com
     * @bodyParam content string The content that describes the ad. Example: <img alt="Example Banner" src="example-banner.jpg" />
     * @bodyParam type string The content that describes the ad. Could be image, video, html Example: image
     * @bodyParam start_date string Start date for the duration, of the ad. Example: 2024-03-11
     * @bodyParam end_date string Start date for the duration, of the ad. Could be image, video, html Example: 2032-07-05
     * @bodyParam status string Status of the Ad, could be "active", "paused", "draft", "completed" Example: active
     * @bodyParam placement_id integer Id of the Placement, where the ad should be displayed. Example: 1
     */
    public function create(Request $request, AdCampaign $campaign)
    {
        \Illuminate\Support\Facades\Gate::authorize('create', \Jdillenberger\LaravelAds\Models\Advertisement::class);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url',
            'content' => 'required|string',
            'type' => 'required|in:image,video,html',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => 'required|in:active,paused,draft',
            'placement_id' => 'required|exists:ad_placements,id',
        ]);

        $advertisement = $campaign->advertisements()->create($data);

        return $this->successResourceCreated([
            'advertisement' => $advertisement,
        ]);
    }

    /**
     * Single Advertisement
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam campaign integer Id of the Campaign. Example: 1
     * @pathParam advertisement integer Id of the Advertisement. Example: 1
     */
    public function single(AdCampaign $campaign, Advertisement $advertisement)
    {
        \Illuminate\Support\Facades\Gate::authorize('single', $advertisement);

        if (! $campaign->hasAdvertisement($advertisement)) {
            abort(404);
        }

        return $this->successResourceFetched([
            'advertisement' => $advertisement,
        ]);
    }

    /**
     * Update Advertisement
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam campaign integer Id of the Campaign. Example: 1
     * @pathParam advertisement integer Id of the Advertisement. Example: 1
     *
     * @bodyParam title string Title for the Ad. Example: Best ad from our business partner
     * @bodyParam url string The Url a user is redirected to, if the user interacts with the advertisement. Example: https://example.com
     * @bodyParam url string The content that describes the ad. Example: <img alt="Example Banner" src="example-banner.jpg" />
     * @bodyParam type string The content that describes the ad. Could be image, video, html Example: image
     * @bodyParam start_date string Start date for the duration, of the ad. Example: 2024-03-11
     * @bodyParam end_date string Start date for the duration, of the ad. Could be image, video, html Example: 2032-07-05
     * @bodyParam status string Status of the Ad, could be "active", "paused", "draft", "completed" Example: active
     * @bodyParam placement_id integer Id of the Placement, where the ad should be displayed. Example: 1
     */
    public function update(Request $request, AdCampaign $campaign, Advertisement $advertisement)
    {

        \Illuminate\Support\Facades\Gate::authorize('update', $advertisement);

        if (! $campaign->hasAdvertisement($advertisement)) {
            abort(404);
        }

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'link' => 'sometimes|required|url',
            'content' => 'sometimes|required|string',
            'type' => 'sometimes|required|in:image,video,html',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:active,paused,draft',
            'campaign_id' => 'sometimes|required|exists:ad_campaigns,id',
            'placement_id' => 'sometimes|required|exists:ad_placements,id',
        ]);

        $advertisement->update($data);

        return $this->successResourceUpdated([
            'advertisement' => $advertisement,
        ]);
    }

    /**
     * Delete Advertisement
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam campaign integer Id of the Campaign. Example: 1
     * @pathParam advertisement integer Id of the Advertisement. Example: 1
     */
    public function delete(AdCampaign $campaign, Advertisement $advertisement)
    {
        \Illuminate\Support\Facades\Gate::authorize('delete', $advertisement);

        if (! $campaign->hasAdvertisement($advertisement)) {
            abort(404);
        }

        if (! $campaign->delete()) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\ResourceDeletionFailedException;
        }

        return $this->successResourceDeleted();
    }

    /**
     * Impress Advertisement
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam campaign integer Id of the Campaign. Example: 1
     * @pathParam advertisement integer Id of the Advertisement. Example: 1
     */
    public function impress(AdCampaign $campaign, Advertisement $advertisement)
    {
        if (! $campaign->hasAdvertisement($advertisement)) {
            abort(404);
        }

        $interaction = $advertisement->impress();

        return $this->successResourceCreated([
            'interaction' => $interaction,
        ]);
    }

    /**
     * Click Advertisement
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam campaign integer Id of the Campaign. Example: 1
     * @pathParam advertisement integer Id of the Advertisement. Example: 1
     */
    public function click(Request $request, AdCampaign $campaign, Advertisement $advertisement)
    {
        if (! $campaign->hasAdvertisement($advertisement)) {
            abort(404);
        }

        $interaction = $advertisement->click([], $request->method() === 'GET');

        return $this->successResourceCreated([
            'interaction' => $interaction,
        ]);
    }

    /**
     * Summarize Advertisement
     *
     * @authenticated
     *
     * @pathParam prefix string Slug for the current tenant. Example: development
     * @pathParam campaign integer Id of the Campaign. Example: 1
     * @pathParam advertisement integer Id of the Advertisement. Example: 1
     */
    public function summarize(AdCampaign $campaign, Advertisement $advertisement)
    {
        \Illuminate\Support\Facades\Gate::authorize('summarize', $advertisement);

        if (! $campaign->hasAdvertisement($advertisement)) {
            abort(404);
        }

        return $this->successResourceFetched([
            'advertisment' => $advertisement,
            'summary' => [
                'clicks' => $advertisement->clicks()->count(),
                'impressions' => $advertisement->impressions()->count(),
            ],
        ]);
    }
}
