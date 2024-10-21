<?php

namespace Jdillenberger\LaravelBaseline\Exceptions;

class PolicyNotFoundException extends \RuntimeException
{
    public function __construct(string $message = '', $code = 400)
    {
        if ($message === '') {
            $message = __('exception:policy_not_found');
        }

        parent::__construct($message, $code);
    }
}
