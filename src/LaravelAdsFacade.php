<?php

namespace Jdillenberger\LaravelAds;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jdillenberger\LaravelAds\Skeleton\SkeletonClass
 */
class LaravelAdsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-ads';
    }
}
