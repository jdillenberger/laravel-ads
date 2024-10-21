<?php

namespace Jdillenberger\LaravelBaseline\Models;

use Spatie\MediaLibrary\HasMedia;

class User extends \Jdillenberger\LaravelBaseline\Foundation\User implements HasMedia
{
    use \Jdillenberger\LaravelBaseline\Models\Traits\HasAvatar;
    use \Jdillenberger\LaravelBaseline\Models\Traits\IsSettingable;
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \Laravel\Sanctum\HasApiTokens;
    use \Spatie\Permission\Traits\HasRoles;
    use \Jdillenberger\LaravelBaseline\Models\Traits\HasTags;

    protected static $policy = \Jdillenberger\LaravelBaseline\Policies\UserPolicy::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'salutation',
        'title',
        'avatar',
        'email',
        'mobile',
        'notes',
        'locale_id',
        'created_by_id',
        'password',
        'created_by',
        'updated_by',
        'email_verified_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'is_anonymous',
        'avatar',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function booted()
    {
        static::updating(function (User $user) {
            if ($user->isDirty(['email'])) {
                $user->attributes['email_verified_at'] = null;
            }
        });
    }

    public function getIsAnonymousAttribute()
    {
        return ! array_key_exists('email', $this->attributes);
    }
}
