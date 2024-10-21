<?php

use Jdillenberger\LaravelBaseline\Controllers\TagInstancesController;
use Jdillenberger\LaravelBaseline\Controllers\TagModelsController;
use Jdillenberger\LaravelBaseline\Controllers\TagsController;
use Illuminate\Support\Facades\Route;

$taggables = array_keys(config('laravel-baseline.tags.tagable_models'));
$taggables_slugs = collect($taggables)->keys()->map(function ($taggable) {
    return \Illuminate\Support\Str::plural($taggable);
});

// Tags
Route::get('', [TagsController::class, 'list']);
Route::get('{tag}', [TagsController::class, 'single'])->whereNumber('tag');
Route::post('{tag}/delete', [TagsController::class, 'delete'])->whereNumber('tag');

// Tags for Model Classes
Route::get('models', [TagModelsController::class, 'listTaggableModels']);
Route::group(['prefix' => '{model}'], function () {
    Route::get('', [TagModelsController::class, 'getTagsForModelSlug']);
    Route::get('{delimited_tag_slugs}', [TagModelsController::class, 'taggedWith']);
})->whereIn('class', array_keys(config('laravel-baseline.tags.tagable_models')));

// Tags for Model Instances
Route::group(['prefix' => '{taggable_type}/{taggable_id}'], function () {
    Route::get('', [TagInstancesController::class, 'listInstanceTags']);
    Route::post('attach/{tags}', [TagInstancesController::class, 'attach']);
    Route::post('detach/{tags}', [TagInstancesController::class, 'detach']);
})->whereIn('class', array_keys(config('laravel-baseline.tags.tagable_models')))->whereNumber('taggable_id');
