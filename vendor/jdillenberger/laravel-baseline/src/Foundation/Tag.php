<?php

namespace Jdillenberger\LaravelBaseline\Foundation;

/**
 * Used only to be able to overwrite Tratit attributes in child class
 */
class Tag extends \Spatie\Tags\Tag
{
    use \Jdillenberger\LaravelBaseline\Models\Traits\HasPolicy;
    use \Mehradsadeghi\FilterQueryString\FilterQueryString;
}
