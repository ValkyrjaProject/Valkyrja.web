<?php

namespace Botwinder\Providers;

class DiscordProvider extends \LaravelRestcord\Authentication\Socialite\DiscordProvider
{
    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        if (!array_key_exists('email', $user)) {
            $user['email'] = null;
        }
        return parent::mapUserToObject($user);
    }

}