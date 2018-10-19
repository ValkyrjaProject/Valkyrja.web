<?php

namespace Valkyrja\Providers;

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
            $app->bind('Valkyrja\Logic\AuthenticateUserInterface', 'Valkyrja\Logic\AuthenticateUser');
            $app->bind('Valkyrja\Logic\DiscordDataInterface', 'Valkyrja\Logic\DiscordData');
        } else {
            $app->bind('Valkyrja\Logic\AuthenticateUserInterface', 'Valkyrja\Logic\LocalAuthenticateUser');
            $app->bind('Valkyrja\Logic\DiscordDataInterface', 'Valkyrja\Logic\LocalDiscordData');
        }
    }
}
