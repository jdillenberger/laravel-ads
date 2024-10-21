<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class InvalidUserCredentialsException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 400)
    {
        if ($message === '') {
            $message = __('exception:credentials_invalid');
        }

        parent::__construct($message, $code);
    }
}
