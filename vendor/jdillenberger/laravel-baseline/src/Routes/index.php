<?php

use Illuminate\Support\Facades\Route;

Route::get('', [\Jdillenberger\LaravelBaseline\Controllers\IndexController::class, 'index']);
Route::get('enable', [\Jdillenberger\LaravelBaseline\Controllers\IndexController::class, 'enableTenant']);