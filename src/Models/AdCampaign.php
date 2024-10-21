<?php

namespace Jdillenberger\LaravelAds\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdCampaign extends \Jdillenberger\LaravelBaseline\Foundation\Model
{
    use \Jdillenberger\LaravelBaseline\Models\Traits\IsCreatedBy;
    use \Jdillenberger\LaravelBaseline\Models\Traits\IsUpdatedBy;
    use \Jdillenberger\LaravelBaseline\Models\Traits\ScopesTenant;
    use HasFactory;
    use \Spatie\Tags\HasTags;

    protected static $policy = \Jdillenberger\LaravelAds\Policies\AdCampaignPolicy::class;

    protected $fillable = [
        'name',
        'budget',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the advertisements for the campaign.
     */
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'campaign_id');
    }

    public function hasAdvertisement(Advertisement $advertisement)
    {
        return $this->id === $advertisement->campaign_id;
    }
}
