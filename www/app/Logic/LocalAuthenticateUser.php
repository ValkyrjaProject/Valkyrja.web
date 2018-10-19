<?php
/**
 * Created by PhpStorm.
 * User: spytec
 * Date: 10/16/18
 * Time: 1:29 PM
 */

namespace Valkyrja\Logic;


use Valkyrja\Models\Sample\DiscordGuild;
use Valkyrja\Models\Sample\DiscordUser;
use Illuminate\Support\Collection;
use Laravel\Socialite\Two\User;
use LaravelRestcord\Discord\Guild;

class LocalAuthenticateUser implements AuthenticateUserInterface
{
    /**
     * @var User|null
     */
    private static $user = null;

    public static function logout(): void
    {
        session()->invalidate();
    }

    /**
     * {@inheritdoc}
     */
    public static function create()
    {
        return new LocalAuthenticateUser();
    }

    /**
     * @param User $user
     */
    public function setUser($user): void
    {
        self::$user = $user;
    }

    /**
     * @param bool $hasCode Whether or not we are returning from Discord OAuth2
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute(bool $hasCode)
    {
        session()->put('discord_token', 'discord_token');
        return redirect('/');
    }

    /**
     * Retrieve and return user
     *
     * @param bool $strict
     * @return User|null
     */
    public function get(bool $strict = true)
    {
        if (self::hasDiscordToken()) {
            $user = new User;
            $user->map(DiscordUser::first()->toArray());
            return $user;
        }
        return null;
    }

    public function guilds()
    {
        if (self::hasDiscordToken()) {
            $discordGuilds = DiscordGuild::all();
            $guilds = collect();
            $discordGuilds->each(function($discordGuild) use ($guilds) {
                $guilds->push(new Guild($discordGuild->toArray()));
            });
            return $guilds;
        }
        return collect();

    }

    public static function hasDiscordToken()
    {
        return session()->has('discord_token');
    }

    public static function getDiscordToken()
    {
        return session()->get('discord_token');
    }

    public function isSuperAdmin(): bool
    {
        return self::admins()->contains($this->get()->getId());
    }

    public static function admins(): Collection
    {
        return collect(explode(',', env('VALKYRJA_ADMINS')));
    }
}
