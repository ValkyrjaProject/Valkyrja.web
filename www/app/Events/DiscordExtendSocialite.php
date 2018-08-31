<?php

namespace Botwinder\Events;

use Botwinder\Providers\DiscordProvider;

class DiscordExtendSocialite extends \LaravelRestcord\Authentication\Socialite\DiscordExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(\SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('discord', DiscordProvider::class);
    }
}
