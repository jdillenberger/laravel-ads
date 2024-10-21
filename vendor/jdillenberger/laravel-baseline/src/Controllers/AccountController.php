<?php

namespace Jdillenberger\LaravelBaseline\Controllers;

use \Jdillenberger\LaravelBaseline\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Psl\Type\array_key;

/**
 * @group Account
 */
class AccountController extends \Jdillenberger\LaravelBaseline\Foundation\Controller
{
    /**
     * Current Account
     *
     * Returns account of the current user.
     *
     * @authenticated
     * 
     * @pathParam prefix string slug for the current tenant. Example: development
     */
    public function user(Request $request)
    {
        $user = $this->requireAuthenticated();
        $user->load('settings');

        return $this->successResourceFetched(['user' => $user]);
    }

    /**
     * Login using Credentials
     * 
     * @pathParam prefix string slug for the current tenant. Example: development
     *
     * @bodyParam email string required The email of the user. Example: john.doe@domain.tld
     * @bodyParam password string required The password of the user. Example: password
     */
    public function loginUsingCredentials(Request $request)
    {
        $user = $this->requireValidCredentials();

        if (! $user instanceof \Jdillenberger\LaravelBaseline\Models\User) {
            return;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success(__('success:login_successful'), data: [
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Request Login Token
     * 
     * @pathParam prefix string slug for the current tenant. Example: development
     *
     * @bodyParam email string required The email of the user. Example: john.doe@domain.tld
     */
    public function requestLoginToken(Request $request)
    {
        $user = User::where($request->only('email'))->first();

        if ($user) {

            $token = $this->newCryptToken('login_link_request', [
                'user_id' => $user->id,
            ], expires: \Carbon\Carbon::now()->addMinutes(30));

            event(new \Jdillenberger\LaravelBaseline\Events\UserLoginRequest($user, $token));

        }

        return $this->success(__('info:maybe_login_mail_send'));
    }

    /**
     * Validate Login Token
     * 
     * @pathParam prefix string slug for the current tenant. Example: development
     *
     * @bodyParam email string required The email of the user. Example: john.doe@domain.tld
     * bodyParam token string login-token for the users Password. Example: ZXlKcGRpSTZJbGczTkhRemJXdHJZbFZtTlhjMlVrVlROekpSWlZFOVBTSXNJblpoYkhWbElqb2lNVFYzVWlzME9USjBaRmR5ZFhaV1F6SnJlVmt2TXpWVlVreEdWSFJZWlUxalV6WTJTSGw0UW0wM0swUjFWa0pRYWtoTE5rTjRjRmhCZUdGbGNUSlNWbUV4YUhsaE5rd3lRM05PYUVWVVZqWkJTbmxWUW5Kck1XVlRaM1V3TWt0YVpuTm1SVVJCWmtGVlNGZE5WVWRZZG14SWFHaDZiSFYyWkdWWk1FRXpRV2tpTENKdFlXTWlPaUl6WXpVeVpEUTJOVE0yTVdZeVpqaG1OakJpT1RGaE9EQTRZbVl5TkRneU1EWTNZakE0TURobE1EZ3dObVl6T0RnMFpEUTBZMk0xT0dJeU5XVTVZVGhoSWl3aWRHRm5Jam9pSW4wPQ%3D%3D)
     */
    public function validateLoginToken(Request $request)
    {
        $decryptedToken = $this->decryptCryptToken($request->token, 'login_link_request');

        if (!array_key_exists('user_id', $decryptedToken)) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\InvalidTokenException;
        }

        $user = User::find($decryptedToken['user_id']);

        if (is_null($user)) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\ResourceNotFoundException();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success(__('success:login_successful'), data: [
            'user' => $user,
            'token' => $token,
        ]);
    }


    /**
     * Create Account
     *
     * Register new Account. Use Email and Password for regular accounts. Leave them for annonymous ones.
     *
     * @pathParam prefix string slug for the current tenant. Example: development
     * 
     * @bodyParam email string The email of the user. Example: jane.doe@domain.tld
     * @bodyParam password string The password of the user. Example: password
     */
    public function create(Request $request)
    {
        $user = new User([]);

        $maybeEmailAndPassword = Validator::make($request->all(), [
            'email' => ['required_with:password', 'string', 'email'],
            'password' => ['required_with:email', 'string', 'min:6'],
        ])->valid();

        $has_email = array_key_exists('email', $maybeEmailAndPassword);

        if ($has_email) {
            $request->validate(['email' => ['unique:users,email']]);
        }

        $user->fill($maybeEmailAndPassword);
        $user->save();

        event(new \Illuminate\Auth\Events\Registered($user));

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResourceCreated([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Delete Account
     *
     * Delete account of the current user.
     *
     * @authenticated
     * 
     * @pathParam prefix string slug for the current tenant. Example: development
     */
    public function delete(Request $request)
    {
        $user = $this->requireAuthenticated();
        return $this->defaultDelete($user);
    }

    /**
     * Update Account
     *
     * Modify account of the current user.
     *
     * @authenticated
     * 
     * @pathParam prefix string slug for the current tenant. Example: development
     *
     * @bodyParam email string The email of the user. Example: john.doe@domain.tld
     * @bodyParam password string The password of the user. Example: password
     * @bodyParam old_password string Only as authorization for password-changes.. Example: password
     */
    public function update(Request $request)
    {
        $user = $this->requireAuthenticated();

        if ($request->has('email') && $request->email !== $user->email) {
            $request->validate(['email' => ['email',  'unique:users,email']]);

            $email_token = $this->newCryptToken('email_verification_request', ['email' => $request->email], expires: \Carbon\Carbon::now()->addDays(2));
            event(new \Jdillenberger\LaravelBaseline\Events\UserEmailUpdateRequested($user, $request->email, $email_token));
        }

        $user->fill($request->except(['email', 'password']));

        if ($request->has('password')) {

            if (! \Illuminate\Support\Facades\Hash::check($request->old_password ?? '', $user->password)) {
                throw new Exception('Authorization failed. Please enter your "old_password" to authorize the change.');
            }

            $user->fill($request->only(['password']));
        }

        $user->save();

        $result = ['user' => $user];

        if (! is_null($email_token ?? null)) {
            $result['email'] = [
                'message' => __('info:verification_requested'),
                'updated' => $request->email,
            ];
        }

        return $this->successResourceUpdated($result);
    }

    /**
     * Verify Email
     * 
     * @pathParam prefix string slug for the current tenant. Example: development
     *
     * @bodyParam token string VerificationToken for a new Email address. Example:ZXlKcGRpSTZJbEZyU0djeldXdGFhbUp4VUdsb2F6WjNVR2xxYTNjOVBTSXNJblpoYkhWbElqb2liR3czYWxSS2JWcGhaVW93V0ZjMWNVaDJSVzByVWxkNVJFbG5SWFJMUzFSSFJDOWFkbGh1YUhwV2NVTk5UbHA0TDB4c1dETkVkVmt6YUdSUlpVaGFVa2hFY2tabE5EZHJVVWxFV2xCdmNsVjZSekI2TXpCUlNGQllialpqZEZkSE0zRldSekpwVEc1ak5XcFBiekpTVEdwT1dWcGFjVGNyWlZoS2NtVnNkbmxzTTJSUE1GcDRTSGRsTjJkQ1prb3hWMWd3UzNKc1UzY3lObmh3YkU4ellubFZabkZMWVd4MUwzRm5QU0lzSW0xaFl5STZJall6TnpGaU9UQXpPVFEyTURJMU1UWmtaV05tTUdJMVpqRTFZak5sWTJOaVpqTmxOR1ptWVRnNFpHTTFObVF4T0RsbVpqQTRNbVl6T1dSa1pHVmtOR1FpTENKMFlXY2lPaUlpZlE9PQ==
     */
    public function verifyEmail(Request $request)
    {

        $decryptedToken = $this->decryptCryptToken($request->token, 'email_verification_request');

        $user = User::find($decryptedToken['issuer_id']);

        if (! $user) {
            throw new Exception('User for token not found');
        }

        $old_email = $user->email;

        if (Carbon::parse($decryptedToken['issued_at']) < $user->email_verified_at) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\InvalidTokenException;
        }

        $user->update([
            'email' => $decryptedToken['email'],
            'email_verified_at' => Carbon::now(),
        ]);

        return $this->successResourceUpdated([
            'user' => $user,
            'email' => [
                'old' => $old_email,
                'new' => $user->email,
            ],
        ]);
    }

    /**
     * Forgot Password
     *
     * Request Email, containing a password-rest link.
     * 
     * @pathParam prefix string Slug for the current tenant. Example: development
     *
     * @bodyParam email string The email of the user. Example: john.doe@domain.tld
     */
    public function forgotPassword(Request $request)
    {
        if (! $request->has('email')) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\RequestDataMissingException;
        }
        
        $user = User::where($request->only('email'))->first();
        
        if (! is_null($user)) {
            $token = $this->newCryptToken('password_reset_request', expires: \Carbon\Carbon::now()->addDays(2));
            event(new \Jdillenberger\LaravelBaseline\Events\UserForgotPassword($user, $token));
        }
        
        return $this->success(__('info:maybe_password_reset_mail_send'));
    }

    /**
     * Reset Password
     *
     * Reset your Password using a reset-token.
     * 
     * @pathParam prefix string slug for the current tenant. Example: development
     *
     * @bodyParam token string password-reset-token for the users Password. Example: ZXlKcGRpSTZJbGczTkhRemJXdHJZbFZtTlhjMlVrVlROekpSWlZFOVBTSXNJblpoYkhWbElqb2lNVFYzVWlzME9USjBaRmR5ZFhaV1F6SnJlVmt2TXpWVlVreEdWSFJZWlUxalV6WTJTSGw0UW0wM0swUjFWa0pRYWtoTE5rTjRjRmhCZUdGbGNUSlNWbUV4YUhsaE5rd3lRM05PYUVWVVZqWkJTbmxWUW5Kck1XVlRaM1V3TWt0YVpuTm1SVVJCWmtGVlNGZE5WVWRZZG14SWFHaDZiSFYyWkdWWk1FRXpRV2tpTENKdFlXTWlPaUl6WXpVeVpEUTJOVE0yTVdZeVpqaG1OakJpT1RGaE9EQTRZbVl5TkRneU1EWTNZakE0TURobE1EZ3dObVl6T0RnMFpEUTBZMk0xT0dJeU5XVTVZVGhoSWl3aWRHRm5Jam9pSW4wPQ%3D%3D)
     * @bodyParam password string The password of the user. Example: password
     */
    public function resetPassword(Request $request)
    {
        $decryptedToken = $this->decryptCryptToken($request->token, 'password_reset_request');

        $user = User::find($decryptedToken['issuer_id']);

        if (! $user) {
            throw new \Jdillenberger\LaravelBaseline\Exceptions\ResourceNotFoundException;
        }

        $user->update([
            'password' => $request->password,
        ]);

        return $this->successResourceUpdated([
            'user' => $user,
        ]);
    }

    /**
     * List Account Tenants
     * 
     * @pathParam prefix string slug for the current tenant. Example: development
     */
    public function tenants(Request $request)
    {
        $user = $this->requireAuthenticated();

        $pager = $user->tenants()->paginate();

        return $this->successResourceFetched([
            'page_meta' => $this->pagerMeta($pager),
            'enabled_tenants' => $pager->items(),
        ]);
    }

    /**
     * Upload Account Avatar
     * 
     * @pathParam prefix string slug for the current tenant. Example: development
     *
     * @bodyParam avatar string required Base64 encoded Image Example: data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==
     */
    public function uploadAvatar(Request $request)
    {
        $user = $this->requireAuthenticated();

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
        }

        if (is_string($request->avatar) && \Illuminate\Support\Str::startsWith($request->avatar, ['data:'])) {
            $avatar = $request->avatar;
        }

        $user->update([
            'avatar' => $avatar,
        ]);

        return $this->successResourceCreated();
    }

    /**
     * Show Account Avatar
     *
     * @pathParam prefix string slug for the current tenant. Example: development
     * 
     * @bodyParam avatar string required Base64 encoded Image Example:
     */
    public function showAvatar(Request $request)
    {
        return $this->requireAuthenticated()->avatar;
    }
}
