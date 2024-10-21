<?php

use Jdillenberger\LaravelBaseline\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('user', [AccountController::class, 'user']);
Route::get('verify-email/{token}', [AccountController::class, 'verifyEmail'])->name('verify-email');
Route::post('forgot-password', [AccountController::class, 'forgotPassword'])->name('forgot-password');
Route::get('reset-password', [AccountController::class, 'resetPassword'])->name('reset-password');
Route::post('login', [AccountController::class, 'loginUsingCredentials'])->name('login');

Route::post('login-token/request', [AccountController::class, 'requestLoginToken'])->name('login-token-request');
Route::get('login-token/validate', [AccountController::class, 'validateLoginToken'])->name('login-token-validation');

Route::post('create', [AccountController::class, 'create']);
Route::post('update', [AccountController::class, 'update']);
Route::post('delete', [AccountController::class, 'delete']);
Route::get('tenants', [AccountController::class, 'tenants']);

Route::get('avatar', [AccountController::class, 'showAvatar']);
Route::post('avatar/upload', [AccountController::class, 'uploadAvatar']);