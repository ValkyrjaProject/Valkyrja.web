<?php

namespace Botwinder\Logic;

use Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Collection;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Laravel\Socialite\Two\User;
use LaravelRestcord\Authentication\Socialite\DiscordProvider;
use LaravelRestcord\Discord;

class AuthenticateUser
{
    use CachesUser;

    /**
     * @var Collection
     */
    private static $guilds;

    /**
     * @var DiscordProvider
     */
    private $socialite;

    /**
     * @var User|null
     */
    private static $user = null;

    /**
     * @var Discord
     */
    private $discord;

    /**
     * AuthenticateUser constructor.
     * @param Socialite $socialite
     */
    public function __construct(Socialite $socialite)
    {
        $this->socialite = $socialite->driver('discord');
    }

    public static function logout(): void
    {
        session()->invalidate();
    }

    /**
     * @param Socialite $socialite
     * @return AuthenticateUser
     */
    public static function create(Socialite $socialite = null)
    {
        if (is_null($socialite)) {
            $socialite = resolve(Socialite::class);
        }
        return new AuthenticateUser($socialite);
    }

    /**
     * @param User $user
     */
    public function setUser($user): void
    {
        $this->setCachedUser(self::getDiscordToken(), $user);
        self::$user = $user;
    }

    /**
     * @return User|null
     */
    private function getUser()
    {
        if (self::hasDiscordToken()) {
            $user = $this->getCachedUser(self::getDiscordToken());
            $this->setUser($user);
        }
        return self::$user;
    }

    /**
     * @param bool $hasCode Whether or not we are returning from Discord OAuth2
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute(bool $hasCode)
    {
        if (!$hasCode) {
            return $this->authorizeWithDiscord();
        }

        $this->requestUser();

        // TODO: Check if other event can be dispatched - Login wants Authenticatable
        Event::dispatch(new Login($this->getUser(), true));

        return redirect('/');
    }

    private function authorizeWithDiscord()
    {
        return $this->socialite->setScopes(['identify', 'guilds'])->redirect();
    }

    private function requestUser(): void
    {
        if (self::hasDiscordToken()) {
            $this->setUser($this->socialite->userFromToken(self::getDiscordToken()));
        } else {
            $this->setUser($this->socialite->user());
        }
    }

    /**
     * Retrieve and return user
     *
     * @param bool $strict
     * @return User|null
     */
    public function get(bool $strict = true)
    {
        if (is_null($user = $this->getUser()) && $strict) {
            start_measure('retrieve user', "Retrieve user from API");
            $this->requestUser();
            stop_measure('retrieve user');
            $user = $this->getUser();
        }
        return $user;
    }

    public function guilds()
    {
        if (self::hasDiscordToken()) {
            $guilds = $this->getCachedGuilds(self::getDiscordToken());
            if (is_null($guilds)) {
                start_measure('retrieve guilds', "Retrieve guilds from API");
                $guilds = $this->discord()->guilds();
                stop_measure('retrieve guilds');
            }
            $this->setGuilds($guilds);
        }
        return self::$guilds;
    }

    public static function hasDiscordToken()
    {
        return session()->has('discord_token');
    }

    public static function getDiscordToken()
    {
        return session()->get('discord_token');
    }

    /**
     * @return DiscordProvider
     */
    public function getSocialite()
    {
        return $this->socialite;
    }

    public function isSuperAdmin(): bool
    {
        return self::admins()->contains($this->get()->getId());
    }

    public static function admins(): Collection
    {
        return collect(explode(',', env('BOTWINDER_ADMINS')));
    }

    private function discord()
    {
        if (is_null($this->discord)) {
            $this->discord = resolve(Discord::class);
        }
        return $this->discord;
    }

    private function setGuilds($guilds)
    {
        $this->setCachedGuilds(self::getDiscordToken(), $guilds);
        self::$guilds = $guilds;
    }

}