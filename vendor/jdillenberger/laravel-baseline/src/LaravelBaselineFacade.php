<?php

namespace Jdillenberger\LaravelBaseline;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jdillenberger\LaravelBaseline\Skeleton\SkeletonClass
 */
class LaravelBaselineFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-baseline';
    }
}
