<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018-04-18
 * Time: 22:40
 */

namespace Tests\Unit\Logic;

use Botwinder\Logic\AuthenticateUser;
use LaravelRestcord\Authentication\Socialite\DiscordProvider;
use Illuminate\Support\Facades\Session;
use LaravelRestcord\Discord;
use Mockery;
use Tests\TestCase;

class AuthenticateUserTest extends TestCase
{

    private $discord;

    /** @var AuthenticateUser $user */
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->discord = Mockery::mock(Discord::class);
        $this->user = AuthenticateUser::create();
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testUserCanLogout()
    {
        Session::shouldReceive('invalidate')
            ->once()
            ->andReturnTrue();

        $this->user::logout();
        $this->addToAssertionCount(1);
    }

    public function testConstructSetsCorrectDependencies()
    {
        $this->assertInstanceOf(DiscordProvider::class, $this->user->getSocialite());
    }

    public function testHasDiscordTokenReturnsTrue()
    {
        session()->put('discord_token', '');
        $this->assertTrue($this->user::hasDiscordToken());
    }

    public function testHasNullDiscordTokenReturnsFalse()
    {
        session()->put('discord_token', null);
        $this->assertFalse($this->user::hasDiscordToken());
    }

    public function testHasDiscordTokenReturnsFalse()
    {
        $this->assertFalse($this->user::hasDiscordToken());
    }

    public function testGetUserDoesReturnWithStrict()
    {
        $this->assertInstanceOf(\Laravel\Socialite\AbstractUser::class, $this->getUserWithStrict(true));
    }

    public function testGetUserDoesReturnWithoutStrict()
    {
        $this->assertInstanceOf(\Laravel\Socialite\AbstractUser::class, $this->getUserWithStrict(false));
    }

    public function testUnsetUserReturnUserWithStrict()
    {
        $socialite = Mockery::mock(\Laravel\Socialite\Contracts\Factory::class);
        $discordProvider = Mockery::mock(DiscordProvider::class);

        $socialite->expects('driver')
            ->andReturn($discordProvider);

        $discordProvider->expects('user')
            ->andReturn(new \Laravel\Socialite\Two\User);

        $user = AuthenticateUser::create($socialite);

        $user->setUser(null);
        $this->assertInstanceOf(\Laravel\Socialite\AbstractUser::class, $user->get(true));
    }

    public function testUnsetUserReturnsNullWithoutStrict()
    {
        $user = AuthenticateUser::create();
        $user->setUser(null);
        $this->assertNull($user->get(false));
    }

    public function testExecuteRedirectsUnauthorizedUserWithCorrectScopes()
    {
        $socialite = Mockery::mock(\Laravel\Socialite\Contracts\Factory::class);

        $discordProvider = Mockery::mock(DiscordProvider::class);

        $socialite->shouldReceive('driver')
            ->once()
            ->andReturn($discordProvider);

        $scopes = ['identify', 'guilds'];
        $discordProvider->shouldReceive('setScopes')
            ->withArgs([$scopes])
            ->once()
            ->andReturn($socialite);

        $socialite->shouldReceive('redirect')
            ->once()
            ->andReturn(\Symfony\Component\HttpFoundation\RedirectResponse::create('/'));

        $user = AuthenticateUser::create($socialite);
        $response = $user->execute(false);
        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\RedirectResponse::class, $response);
    }

    public function testExecuteRedirectsAuthorizedUserToHome()
    {
        $socialite = Mockery::mock(\Laravel\Socialite\Contracts\Factory::class);
        $discordProvider = Mockery::mock(DiscordProvider::class);

        $socialite->shouldReceive('driver')
            ->once()
            ->andReturn($discordProvider);

        $discordProvider->shouldReceive('user')
            ->once()
            ->andReturn(new \Laravel\Socialite\Two\User);

        $user = AuthenticateUser::create($socialite);
        $response = $user->execute(true);

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\RedirectResponse::class, $response);
        $this->assertEquals(url('/'), $response->getTargetUrl());
    }

    private function getUserWithStrict($strict)
    {
        $user = AuthenticateUser::create();
        $user->setUser(new \Laravel\Socialite\Two\User);
        return $user->get($strict);
    }
}
