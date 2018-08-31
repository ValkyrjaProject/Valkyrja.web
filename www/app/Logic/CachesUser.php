<?php

namespace Botwinder\Logic;

use Cache;
use Illuminate\Support\Collection;
use Laravel\Socialite\Two\User;
use LaravelRestcord\Discord\Guild;

trait CachesUser
{
    /** @var Cache */
    private $cache;

    /**
     * CachesUser constructor.
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param $token
     * @param User $user
     */
    public function setCachedUser($token, $user)
    {
        $this->resolveDependencies();
        $this->cache::add("user_" . hash('sha256', $token), $user, 2);
    }

    /**
     * @param $token
     * @return User|null
     */
    public function getCachedUser($token)
    {
        $this->resolveDependencies();
        $hash = "user_" . hash('sha256', $token);
        if ($this->cache::has($hash)) {
            return $this->cache::get($hash);
        }
        return null;
    }

    /**
     * @param $token
     * @param Collection $guilds
     */
    private function setCachedGuilds($token, $guilds)
    {
        $this->resolveDependencies();
        $this->cache::add("guilds_" . hash('sha256', $token), $guilds->jsonSerialize(), 2);
    }


    private function getCachedGuilds($token)
    {
        $this->resolveDependencies();
        $hash = "guilds_" . hash('sha256', $token);
        if ($this->cache::has($hash)) {
            $guilds = collect($this->cache::get($hash))->map(function($guild) {
                return new Guild($guild);
            });
            return $guilds;
        }
        return null;
    }

    private function resolveDependencies($cache = null): void
    {
        if (is_null($this->cache)) {
            if (is_null($cache)) {
                $cache = resolve(Cache::class);
            }
            $this->cache = $cache;
        }
    }
}