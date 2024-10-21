<?php

namespace Jdillenberger\LaravelAds\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Advertisement extends \Jdillenberger\LaravelBaseline\Foundation\Model
{
    use \Jdillenberger\LaravelBaseline\Models\Traits\IsCreatedBy;
    use \Jdillenberger\LaravelBaseline\Models\Traits\IsUpdatedBy;
    use \Jdillenberger\LaravelBaseline\Models\Traits\ScopesTenant;
    use HasFactory;
    use \Spatie\Tags\HasTags;

    protected static $policy = \Jdillenberger\LaravelAds\Policies\AdvertisementPolicy::class;

    protected $fillable = [
        'title',
        'link',
        'content',
        'type',
        'start_date',
        'end_date',
        'status',
        'campaign_id',
        'placement_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the campaign that owns the advertisement.
     */
    public function campaign()
    {
        return $this->belongsTo(AdCampaign::class, 'campaign_id');
    }

    /**
     * Get the placement where this advertisement is displayed.
     */
    public function placement()
    {
        return $this->belongsTo(AdPlacement::class, 'placement_id');
    }

    /**
     * Get the organization that owns this advertisement.
     */
    public function organization()
    {
        return $this->belongsTo(getBaselineTenantModel()::class, 'organization_id');
    }

    public function interactions()
    {
        return $this->hasMany(AdInteraction::class, 'ad_id');
    }

    public function clicks()
    {
        return $this->interactions()->where(['type' => 'click']);
    }

    public function impressions()
    {
        return $this->interactions()->where(['type' => 'impression']);
    }

    public function click($data = [], $redirect = false)
    {
        $click = $this->interactions()->create(array_merge([
            'type' => 'click',
            'ip_address' => request()->ip(),
            'user_id' => Auth::id() ?? null,
        ], $data));

        if ($redirect === true) {
            return redirect()->to($this->link);
        }

        return $click;
    }

    public function impress($data = [])
    {
        return $this->interactions()->create(array_merge([
            'type' => 'impression',
            'ip_address' => request()->ip(),
            'user_id' => Auth::id() ?? null,
        ], $data));
    }
}
