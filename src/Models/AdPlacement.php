<?php

namespace Jdillenberger\LaravelAds\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdPlacement extends \Jdillenberger\LaravelBaseline\Foundation\Model
{
    use \Jdillenberger\LaravelBaseline\Models\Traits\IsCreatedBy;
    use \Jdillenberger\LaravelBaseline\Models\Traits\IsUpdatedBy;
    use \Jdillenberger\LaravelBaseline\Models\Traits\ScopesTenant;
    use HasFactory;

    protected static $policy = \Jdillenberger\LaravelAds\Policies\AdPlacementPolicy::class;

    protected $fillable = [
        'name',
        'description',
        'location',
        'width',
        'height',
    ];

    /**
     * Get the advertisements that belong to this placement.
     */
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class, 'placement_id');
    }
}
