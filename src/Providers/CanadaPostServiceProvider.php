<?php
namespace Webkul\CanadaPost\Providers;

use Illuminate\Support\ServiceProvider;

class CanadaPostServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/../Http/routes.php';

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'canadapost');
        
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'canadapost');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();      
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/carriers.php', 'carriers'
        );
    }

}