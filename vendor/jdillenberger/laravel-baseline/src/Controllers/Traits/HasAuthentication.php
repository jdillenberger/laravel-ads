<?php

namespace Jdillenberger\LaravelBaseline\Controllers\Traits;

trait HasAuthentication
{
    public function requireAuthenticated(): \Illuminate\Database\Eloquent\Model
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (! $user instanceof \Illuminate\Database\Eloquent\Model) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\LoginRequiredException;
        }

        return $user;
    }

    public function requireValidCredentials(): \Illuminate\Foundation\Auth\User
    {
        $credentials = request()->only('email', 'password');

        if (! \Illuminate\Support\Facades\Auth::attempt($credentials)) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\InvalidUserCredentialsException;
        }

        return \Illuminate\Support\Facades\Auth::user();
    }
}
