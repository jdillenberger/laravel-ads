<?php

namespace Jdillenberger\LaravelBaseline\Models\Traits;

trait HasTags
{
    use \Spatie\Tags\HasTags;

    public static function getTagClassName(): string
    {
        return getBaselineTagModel();
    }
}
