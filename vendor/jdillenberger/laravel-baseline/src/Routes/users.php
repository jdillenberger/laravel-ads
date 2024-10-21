<?php

use Jdillenberger\LaravelBaseline\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('', [UsersController::class, 'list'])->where('user', '[0-9]+');
Route::get('{user}', [UsersController::class, 'single'])->where('user', '[0-9]+');
Route::post('create', [UsersController::class, 'create']);
Route::post('{user}/update', [UsersController::class, 'update'])->where('user', '[0-9]+');
Route::post('{user}/delete', [UsersController::class, 'delete'])->where('user', '[0-9]+');
Route::post('{user}/avatar', [UsersController::class, 'showAvatar'])->where('user', '[0-9]+');
Route::post('{user}/avatar/upload', [UsersController::class, 'uploadAvatar'])->where('user', '[0-9]+');

Route::group(['prefix' => '{user}/settings'], function () {

    include __DIR__.'/user_settings.php';

})->where('user', '[0-9]+');
