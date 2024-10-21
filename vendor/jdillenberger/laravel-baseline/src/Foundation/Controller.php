<?php

namespace Jdillenberger\LaravelBaseline\Foundation;

abstract class Controller extends \Illuminate\Routing\Controller
{
    use \Jdillenberger\LaravelBaseline\Controllers\Traits\HasAuthentication;
    use \Jdillenberger\LaravelBaseline\Controllers\Traits\HasAuthentication;
    use \Jdillenberger\LaravelBaseline\Controllers\Traits\HasCryptTokens;
    use \Jdillenberger\LaravelBaseline\Controllers\Traits\HasDefaultApiResponse;
    use \Jdillenberger\LaravelBaseline\Controllers\Traits\HasDefaultCrud;
    use \Jdillenberger\LaravelBaseline\Controllers\Traits\HasPagination;


    public function callAction($method, $parameters)
    {
        unset($parameters['prefix']);
        return parent::callAction($method, $parameters);
    }
}
