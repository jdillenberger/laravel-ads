<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class InvalidTypeException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 500)
    {
        if ($message === '') {
            $message = __('exception:type_error');
        }

        parent::__construct($message, $code);
    }
}
