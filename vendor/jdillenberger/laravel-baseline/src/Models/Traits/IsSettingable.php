<?php

namespace Jdillenberger\LaravelBaseline\Models\Traits;

trait IsSettingable
{
    public function settings()
    {
        $userSettingsClass = getBaselineUserSettingModel();
        
        return $this->morphMany($userSettingsClass, 'meta')->where([
            'class' => $userSettingsClass,
        ]);
    }

    public function hasSetting(\Jdillenberger\LaravelBaseline\Models\UserSetting $meta)
    {
        if (is_null($this->id) || $meta::class !== getBaselineUserSettingModel()) {
            return false;
        }

        return $this->id === $meta->meta_id;
    }
}
