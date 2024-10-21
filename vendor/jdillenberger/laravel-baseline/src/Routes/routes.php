<?php

use Illuminate\Support\Facades\Route;

include __DIR__ . '/index.php';

Route::group(['prefix' => 'account'], function () {
    include __DIR__.'/accounts.php';
});

Route::group(['prefix' => config('laravel-baseline.tenant.rename_slug', 'tenants')], function () {
    include __DIR__.'/tenants.php';
});

Route::group(['prefix' => 'users'], function () {
    include __DIR__.'/users.php';
});

Route::group(['prefix' => 'tags'], function(){
    include __DIR__.'/tags.php';
});