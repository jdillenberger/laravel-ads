<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class ResourceNotFoundException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 400)
    {
        if ($message === '') {
            $message = __('exception:resource_not_found');
        }

        parent::__construct($message, $code);
    }
}
