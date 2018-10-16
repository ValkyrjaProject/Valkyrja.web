<?php
namespace Botwinder\Logic;

use Illuminate\Support\Collection;
use Laravel\Socialite\Two\User;


interface AuthenticateUserInterface
{
    public static function logout(): void;

    /**
     * @return AuthenticateUserInterface
     */
    public static function create();

    /**
     * @param User $user
     */
    public function setUser($user): void;

    /**
     * @param bool $hasCode Whether or not we are returning from Discord OAuth2
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute(bool $hasCode);

    /**
     * Retrieve and return user
     *
     * @param bool $strict
     * @return User|null
     */
    public function get(bool $strict = true);

    public function guilds();

    public static function hasDiscordToken();

    public static function getDiscordToken();

    public function isSuperAdmin(): bool;

    public static function admins(): Collection;
}
