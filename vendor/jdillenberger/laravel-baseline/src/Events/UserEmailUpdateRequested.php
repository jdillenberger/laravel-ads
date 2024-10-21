<?php

namespace Jdillenberger\LaravelBaseline\Events;

class UserEmailUpdateRequested
{
    use \Illuminate\Queue\SerializesModels;

    public $user;

    public $email;

    public $token;

    /**
     * Create a new event instance.
     */
    public function __construct(\Illuminate\Database\Eloquent\Model $user, string $email, string $token)
    {
        $this->user = $user;
        $this->email = $email;
        $this->token = $token;
    }
}
