<?php

use Jdillenberger\LaravelBaseline\Controllers\TenantsController;
use Illuminate\Support\Facades\Route;

Route::get('', [TenantsController::class, 'list']);
Route::get('current', [TenantsController::class, 'current']);
Route::post('create', [TenantsController::class, 'create']);

Route::get('{tenant}', [TenantsController::class, 'single'])->where('tenant', '[0-9]+');
Route::post('{tenant}/update', [TenantsController::class, 'update'])->where('tenant', '[0-9]+');
Route::post('{tenant}/delete', [TenantsController::class, 'delete'])->where('tenant', '[0-9]+');
