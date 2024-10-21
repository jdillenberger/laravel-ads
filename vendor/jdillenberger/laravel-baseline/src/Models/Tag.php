<?php

namespace Jdillenberger\LaravelBaseline\Models;

use Exception;

class Tag extends \Jdillenberger\LaravelBaseline\Foundation\Tag
{
    protected static $policy = \Jdillenberger\LaravelBaseline\Policies\TagPolicy::class;

    public function taggables(?string $class = null)
    {
        if ($class === null || ! class_exists($class)) {
            throw new Exception('Can not Tag '.var_export($class));
        }

        return $this->morphedByMany($class, 'taggable');
    }
}
