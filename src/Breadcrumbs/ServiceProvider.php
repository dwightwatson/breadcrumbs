<?php

namespace Watson\Breadcrumbs;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/breadcrumbs.php', 'breadcrumbs');

        $this->app->singleton('breadcrumbs.manager', Manager::class);
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/breadcrumbs.php' => config_path('breadcrumbs.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__.'/../views', 'breadcrumbs');

        if (file_exists($file = $this->app['path.base'].'/routes/breadcrumbs.php')) {
            require $file;
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['breadcrumbs.manager'];
    }
}
