<?php

namespace Watson\Breadcrumbs;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/breadcrumbs.php', 'breadcrumbs');

        $this->app->singleton('breadcrumbs', function ($app) {
            return $app->make(Manager::class);
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Can't generate breadcrumbs in the console as there is no route
            // from which we can build the trail from.
            return;
        }

        $this->publishes([
            __DIR__.'/../config/breadcrumbs.php' => config_path('breadcrumbs.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/breadcrumbs')
        ], 'views');

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
        return ['breadcrumbs'];
    }
}
