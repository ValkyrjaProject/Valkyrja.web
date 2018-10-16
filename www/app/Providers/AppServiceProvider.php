<?php

namespace Botwinder\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        if (App::environment('production')) {
            $app->bind('Botwinder\Logic\AuthenticateUserInterface', 'Botwinder\Logic\AuthenticateUser');
            $app->bind('Botwinder\Logic\DiscordDataInterface', 'Botwinder\Logic\DiscordData');
        } else {
            $app->bind('Botwinder\Logic\AuthenticateUserInterface', 'Botwinder\Logic\LocalAuthenticateUser');
            $app->bind('Botwinder\Logic\DiscordDataInterface', 'Botwinder\Logic\LocalDiscordData');
        }
    }
}
