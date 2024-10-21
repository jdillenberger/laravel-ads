<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class InvalidRequestException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 400)
    {
        if ($message === '') {
            $message = __('exception:bad_request');
        }

        parent::__construct($message, $code);
    }
}
