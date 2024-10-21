<?php

namespace Jdillenberger\LaravelBaseline\Controllers\Traits;

use Carbon\Carbon;

trait HasCryptTokens
{
    protected function decryptCryptToken($token, $expectedPurpose)
    {
        try {
            $tokenData = json_decode(\Illuminate\Support\Facades\Crypt::decryptString(base64_decode($token)), true);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\InvalidTokenException;
        }

        if ($tokenData['purpose'] !== $expectedPurpose) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\InvalidTokenException;
        }

        if (array_key_exists('expires', $tokenData) && \Carbon\Carbon::now() > \Carbon\Carbon::parse($tokenData['expires'])) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\ResourceExpiredException;
        }

        return $tokenData;
    }

    protected function newCryptToken(string $purpose, $data = [], ?string $expires = null)
    {
        $tokenData = [
            'purpose' => $purpose,
            'issuer_id' => \Illuminate\Support\Facades\Auth::id() ?? null,
            'issued_at' => (string) Carbon::now(),
        ];

        if (! is_null($expires)) {
            $tokenData['expires'] = $expires;
        }

        $tokenData = array_merge($data, $tokenData);

        return base64_encode(\Illuminate\Support\Facades\Crypt::encryptString(json_encode($tokenData)));
    }
}
