<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class LoginRequiredException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 400)
    {
        if ($message === '') {
            $message = __('exception:authorization_required');
        }

        parent::__construct($message, $code);
    }
}
