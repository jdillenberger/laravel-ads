<?php

function getBaselineUserModel()
{
    return config('laravel-baseline.models.user', \Jdillenberger\LaravelBaseline\Models\User::class);
}

function getBaselineTenantModel()
{
    return config('laravel-baseline.models.tenant', \Jdillenberger\LaravelBaseline\Models\Tenant::class);
}

function getBaselineUserSettingModel()
{
    return config('laravel-baseline.models.user-setting', \Jdillenberger\LaravelBaseline\Models\UserSetting::class);
}

function getBaselineTagModel()
{
    return config('laravel-baseline.models.tag', \Jdillenberger\LaravelBaseline\Models\Tag::class);
}