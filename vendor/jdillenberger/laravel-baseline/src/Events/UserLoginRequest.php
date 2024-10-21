<?php

namespace Jdillenberger\LaravelBaseline\Events;

class UserLoginRequest
{
    use \Illuminate\Queue\SerializesModels;

    public $user;

    public $token;

    /**
     * Create a new event instance.
     */
    public function __construct(\Illuminate\Database\Eloquent\Model $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }
}
