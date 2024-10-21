<?php

namespace Jdillenberger\LaravelBaseline;

class LaravelBaseline
{
    public static function routes($options = [])
    {
        return \Illuminate\Support\Facades\Route::group($options, function () {
    
            include __DIR__ . '/Routes/routes.php';
        
        });
    }
}
