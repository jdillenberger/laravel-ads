<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class AlreadyVerifiedException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 400)
    {
        if ($message === '') {

        }

        parent::__construct($message, $code);
    }
}
