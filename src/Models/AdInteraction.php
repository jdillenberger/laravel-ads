<?php

namespace Jdillenberger\LaravelAds\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AdInteraction extends \Jdillenberger\LaravelBaseline\Foundation\Model
{
    use \Jdillenberger\LaravelBaseline\Models\Traits\IsCreatedBy;
    use \Jdillenberger\LaravelBaseline\Models\Traits\ScopesTenant;
    use HasFactory;

    protected $fillable = [
        'type',
        'ad_id',
        'latitude',
        'longitude',
        'ip_address',
        'user_id',
        'url',
    ];

    /**
     * Get the advertisement associated with the interaction.
     */
    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class, 'ad_id');
    }

    /**
     * Get the placement associated with the interaction.
     */
    public function placement()
    {
        return $this->belongsTo(AdPlacement::class, 'placement_id');
    }

    /**
     * Get the user that interacted with the ad.
     */
    public function user(): MorphTo
    {
        return $this->belongsTo(getBaselineUserModel(), 'user_id');
    }
}
