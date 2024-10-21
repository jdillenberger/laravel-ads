<?php

namespace Jdillenberger\LaravelAds;

use Illuminate\Support\ServiceProvider;

class LaravelAdsServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-ads.php', 'laravel-ads');

        $this->app->singleton('laravel-ads', function () {
            return new LaravelAds;
        });
    }
    
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-ads.php'),
            ], 'config');

            $this->publishesMigrations([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ]);
        }

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    
}
