<?php

use Jdillenberger\LaravelAds\Controllers\AdvertisementsController;
use Illuminate\Support\Facades\Route;

Route::get('', [AdvertisementsController::class, 'list']);
Route::post('create', [AdvertisementsController::class, 'create'])->name('ads.create');
Route::get('{advertisement}', [AdvertisementsController::class, 'single'])->name('ads.single');
Route::post('{advertisement}/update', [AdvertisementsController::class, 'update'])->name('ads.update');
Route::post('{advertisement}/delete', [AdvertisementsController::class, 'delete'])->name('ads.delete');
Route::post('{advertisement}/impress', [AdvertisementsController::class, 'impress'])->name('ads.impress');
Route::match(['post', 'get'], '{advertisement}/click', [AdvertisementsController::class, 'click'])->name('ads.click');
Route::get('{advertisement}/summarize', [AdvertisementsController::class, 'summarize'])->name('ads.single.summarize');
