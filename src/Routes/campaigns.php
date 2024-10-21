<?php

use Jdillenberger\LaravelAds\Controllers\AdCampaignsController;
use Illuminate\Support\Facades\Route;

Route::get('', [AdCampaignsController::class, 'list']);
Route::post('create', [AdCampaignsController::class, 'create'])->name('ads.campaign.create');
Route::get('{campaign}', [AdCampaignsController::class, 'single'])->name('ads.campaign.single');
Route::post('{campaign}/update', [AdCampaignsController::class, 'update'])->name('ads.campaign.update');
Route::post('{campaign}/delete', [AdCampaignsController::class, 'delete'])->name('ads.campaign.delete');

include __DIR__.'/advertisements.php';
