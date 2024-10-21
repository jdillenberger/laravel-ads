<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class ResourceExpiredException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 400)
    {
        if ($message === '') {
            $message = __('exception:resource_expired');
        }

        parent::__construct($message, $code);
    }
}
