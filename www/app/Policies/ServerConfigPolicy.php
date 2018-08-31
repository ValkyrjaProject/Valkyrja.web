<?php

namespace Botwinder\Policies;

use Botwinder\Logic\AuthenticateUser;
use Botwinder\ServerConfig;
use LaravelRestcord\Discord;
use LaravelRestcord\Discord\Guild;
use LaravelRestcord\Discord\Permissions\Permission;
use Laravel\Socialite\Two\User;

class ServerConfigPolicy
{
    /**
     * @var User
     */
    private $user;


    /**
     * @param AuthenticateUser $user
     * @return bool|null
     */
    public function before($user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
        return null; // not super admin, continue with policy check
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param AuthenticateUser $user
     * @param ServerConfig $config
     * @return bool
     */
    public function update($user, $config): bool
    {
        if (is_null($config) || is_null($user)) {
            return false;
        }

        $user->get();
        $this->user = $user;

        /** @var Guild $guild */
        $guild = $this->user->guilds()->first(function (Guild $guild) use (&$config) {
            return (string)$guild->id() === $config->serverid;
        }, null);

        if (is_null($guild)) {
            return false;
        }

        return $this->isOwner($guild) || $this->hasPermissions($guild);
    }

    /**
     * @param Guild $guild
     * @return bool
     */
    public function isOwner(Guild $guild): bool
    {
        return (bool) $guild->get('owner');
    }

    /**
     * Check whether user has Manage Server or Administrator permissions
     * @param Guild $guild
     * @return bool
     */
    public function hasPermissions(Guild $guild): bool
    {
        return $guild->userCan(Permission::MANAGE_GUILD);
    }
}
