<?php
use Jdillenberger\LaravelAds\Controllers\AdCampaignsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'campaigns'], function () {
    include __DIR__.'/campaigns.php';
});

Route::group(['prefix' => 'placements'], function () {
    include __DIR__.'/placements.php';
});
