<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class IocContainerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Name-IocContainer', function(){
            return new \App\Http\Controllers\IocContainerController;
        });
    }
}
