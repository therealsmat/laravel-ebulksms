<?php

namespace therealsmat\Ebulksms;

use Illuminate\Support\ServiceProvider;

class EbulkSmsServiceProvider extends ServiceProvider
{
    /**
    * Indicates if loading of the provider is deferred.
    *
    * @var bool
    */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $config = realpath(__DIR__.'/config/config.php');

        $this->publishes([
            $config => config_path('ebulksms.php')
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laravel-ebulksms', function () {
            return new EbulkSMS;
        });
    }

    /**
     * Get the services provided by the provider
     * @return array
     */
    public function provides()
    {
        return ['laravel-ebulksms'];
    }
}