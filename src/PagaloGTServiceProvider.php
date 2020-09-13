<?php

namespace ArielMejiaDev\PagaloGT;

use Illuminate\Support\ServiceProvider;

class PagaloGTServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/pagalogt.php' => config_path('pagalogt.php'),
            ], 'pagalogt-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/pagalogt.php', 'pagalogt');

        // Register the main class to use with the facade
        $this->app->bind('pagalogt', function () {
            return new PagaloGT;
        });
    }
}
