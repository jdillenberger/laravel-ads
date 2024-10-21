<?php

namespace Jdillenberger\LaravelBaseline\Models;

class UserSetting extends \Jdillenberger\LaravelBaseline\Foundation\Model
{
    public $table = 'meta';

    protected static $policy = \Jdillenberger\LaravelBaseline\Policies\UserSettingPolicy::class;

    protected $fillable = [
        'meta_id',
        'meta_type',
        'key',
        'value',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    protected $hidden = [
        'class',
        'meta_type',
        'meta_id',
    ];

    public function settingable()
    {
        return $this->morphTo('meta');
    }

    public static function bootMeta()
    {
        static::creating(function ($meta) {
            $this->class = $meta::class;
        });
    }
}
