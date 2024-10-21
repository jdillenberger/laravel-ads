<?php

namespace Jdillenberger\LaravelBaseline\Models\Traits;

trait HasPolicy
{
    protected static $policy = '';

    public static function getPolicyClass()
    {
        if (! is_null(static::$policy) || ! class_exists(static::$policy)) {
            return static::$policy;
        }

        throw new \Jdillenberger\LaravelBaseline\Exceptions\PolicyNotFoundException;
    }
}
