<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class InvalidTokenException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 400)
    {
        if ($message === '') {
            $message = __('exception:token_invalid');
        }

        parent::__construct($message, $code);
    }
}
