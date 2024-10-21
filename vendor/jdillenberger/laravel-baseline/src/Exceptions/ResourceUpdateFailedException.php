<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class ResourceUpdateFailedException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 400)
    {
        if ($message === '') {
            $message = __('exception:resource_update_failed');
        }

        parent::__construct($message, $code);
    }
}
