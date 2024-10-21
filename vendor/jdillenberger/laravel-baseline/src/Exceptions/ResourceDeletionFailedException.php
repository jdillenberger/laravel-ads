<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class ResourceDeletionFailedException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 400)
    {
        if ($message === '') {
            $message = __('exception:resource_deletion_failed');
        }

        parent::__construct($message, $code);
    }
}
