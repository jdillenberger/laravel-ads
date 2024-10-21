<?php

namespace Jdillenberger\LaravelBaseline\Foundation;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    use \Jdillenberger\LaravelBaseline\Models\Traits\HasPolicy;
    use \Mehradsadeghi\FilterQueryString\FilterQueryString;

    protected $filters = [
        'sort',
        'greater',
        'greater_or_equal',
        'less',
        'less_or_equal',
        'between',
        'not_between',
        'like',
        'in',
    ];
}
