<?php

namespace Jdillenberger\LaravelBaseline\Models\Traits;

trait IsCreatedBy
{
    public static function bootIsCreatedBy()
    {
        static::creating(function ($model) {
            if (! array_key_exists('created_by', $model->attributes)) {
                $model->attributes['created_by'] = \Illuminate\Support\Facades\Auth::id();
            }
        });
    }

    public function created_by()
    {
        return $this->belongsTo(getBaselineUserModel(), 'created_by');
    }
}
