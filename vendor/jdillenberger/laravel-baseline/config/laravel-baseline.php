<?php

return [

    'tenant' => [
        
        'rename_slug' => 'organizations',
        
        'auto_prefix' => true,
        
        'default' => 3,
        
        'cli_fallback' => 1,

        
    ],

    'models' => [
        'tenant' => \Jdillenberger\LaravelBaseline\Models\Tenant::class,
        'user' => \Jdillenberger\LaravelBaseline\Models\User::class,
        'user-setting' => \Jdillenberger\LaravelBaseline\Models\UserSetting::class,
        'tag' => \Jdillenberger\LaravelBaseline\Models\Tag::class,
    ],

    'tags' => [

        'tagable_models' => [

            'user' => \Jdillenberger\LaravelBaseline\Models\User::class,

            'organization' => \Jdillenberger\LaravelBaseline\Models\Tenant::class,
        ],

    ]

    
];
