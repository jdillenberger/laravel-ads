<?php

namespace Jdillenberger\LaravelBaseline;

use Illuminate\Support\ServiceProvider;

class LaravelBaselineServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-baseline.php', 'laravel-baseline');
    }

    public function boot()
    {
        $this->registerHelperFunctions();
        $this->registerPolicyDetection();
        $this->publishCustomizables();
        $this->registerConsoleCommands();
    }

    private function registerPolicyDetection()
    {
        \Illuminate\Support\Facades\Gate::guessPolicyNamesUsing(function (string $modelClass) {
            if (method_exists($modelClass, 'getPolicyClass')) {
                return $modelClass::getPolicyClass();
            }
        });
    }

    private function publishCustomizables()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('laravel-baseline.php'),
        ], 'config');
    }

    public function registerHelperFunctions()
    {
        include_once __DIR__ . '/Support/ModelFinder.php';
    }

    public function registerConsoleCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            \Jdillenberger\LaravelBaseline\Commands\ImpersonateAuthCommand::class,
        ]);
    }

    public function setTenantDefaults()
    {
        $tenant = getBaselineTenantModel()::current();

        if (is_null($tenant) && app()->runningInConsole()){
            $tenant = getBaselineTenantModel()::find(config('laravel-baseline.tenant.cli_fallback', 1));
        }

        if(!is_null($tenant)) {
            \Illuminate\Support\Facades\URL::defaults(['prefix' => $tenant->prefix]);
        }
    }
}
