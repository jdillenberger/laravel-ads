<?php

namespace Jdillenberger\LaravelBaseline\Models\Traits;

use \Jdillenberger\LaravelBaseline\Models\User;
use Illuminate\Support\Facades\Auth;

trait IsUpdatedBy
{
    public static function bootIsUpdatedBy()
    {
        static::saving(function ($model) {
            if (! array_key_exists('updated_by', $model->attributes)) {
                $model->attributes['updated_by'] = Auth::id();
            }
        });
    }

    public function updated_by()
    {
        return $this->belongsTo(getBaselineUserModel(), 'updated_by');
    }
}
