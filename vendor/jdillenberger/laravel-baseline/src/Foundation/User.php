<?php

namespace Jdillenberger\LaravelBaseline\Foundation;

class User extends \Illuminate\Foundation\Auth\User
{
    use \Jdillenberger\LaravelBaseline\Models\Traits\HasPolicy;
    use \Jdillenberger\LaravelBaseline\Models\Traits\ScopesManyTenants;
    use \Mehradsadeghi\FilterQueryString\FilterQueryString;
    use \Spatie\MediaLibrary\InteractsWithMedia;
}
