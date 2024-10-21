<?php

use Jdillenberger\LaravelAds\Controllers\AdPlacementsController;
use Illuminate\Support\Facades\Route;

Route::get('', [AdPlacementsController::class, 'list']);
Route::post('create', [AdPlacementsController::class, 'create'])->name('ads.campaign.create');
Route::get('{placement}', [AdPlacementsController::class, 'single'])->name('ads.campaign.single');
Route::post('{placement}/update', [AdPlacementsController::class, 'update'])->name('ads.campaign.update');
Route::post('{placement}/delete', [AdPlacementsController::class, 'delete'])->name('ads.campaign.delete');
