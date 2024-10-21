<?php

use Jdillenberger\LaravelBaseline\Controllers\UserSettingsController;
use Illuminate\Support\Facades\Route;

Route::get('', [UserSettingsController::class, 'list']);
Route::get('{setting}', [UserSettingsController::class, 'single'])->where('setting', '[0-9]+');
Route::post('create', [UserSettingsController::class, 'create']);
Route::post('{setting}/update', [UserSettingsController::class, 'update'])->where('setting', '[0-9]+');
Route::post('{setting}/delete', [UserSettingsController::class, 'delete'])->where('setting', '[0-9]+');
