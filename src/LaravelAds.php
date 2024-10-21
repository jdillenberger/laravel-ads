<?php

namespace Jdillenberger\LaravelAds;

class LaravelAds
{
    public static function routes($options = [])
    {
        return \Illuminate\Support\Facades\Route::group($options, function () {
    
            include __DIR__ . '/Routes/routes.php';
        
        });
    }
}
