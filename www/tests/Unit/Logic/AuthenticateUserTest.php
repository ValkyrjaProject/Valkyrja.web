<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018-04-18
 * Time: 22:40
 */

namespace Tests\Unit\Logic;

use Valkyrja\Logic\AuthenticateUser;
use Valkyrja\Logic\AuthenticateUserInterface;
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

    public function testImplementsAuthenticateUserInterface()
    {
        $this->assertInstanceOf(AuthenticateUserInterface::class, new AuthenticateUser());
    }

    public function testSetSocialiteCallsDriver()
    {
        $socialite = Mockery::mock(\Laravel\Socialite\Contracts\Factory::class);

        $socialite->expects('driver');
        $this->addToAssertionCount(1);

        $user = new AuthenticateUser;
        $user->setSocialite($socialite);
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
        $this->addToAssertionCount(1);

        $discordProvider->expects('user')
            ->andReturn(new \Laravel\Socialite\Two\User);
        $this->addToAssertionCount(1);

        $user = new AuthenticateUser;
        $user->setSocialite($socialite);

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
        $this->addToAssertionCount(1);

        $scopes = ['identify', 'guilds'];
        $discordProvider->shouldReceive('setScopes')
            ->withArgs([$scopes])
            ->once()
            ->andReturn($socialite);
        $this->addToAssertionCount(1);

        $socialite->shouldReceive('redirect')
            ->once()
            ->andReturn(\Symfony\Component\HttpFoundation\RedirectResponse::create('/'));

        $user = new AuthenticateUser;
        $user->setSocialite($socialite);
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
        $this->addToAssertionCount(1);

        $discordProvider->shouldReceive('user')
            ->once()
            ->andReturn(new \Laravel\Socialite\Two\User);
        $this->addToAssertionCount(1);

        $user = new AuthenticateUser;
        $user->setSocialite($socialite);
        $response = $user->execute(true);

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\RedirectResponse::class, $response);
        $this->assertEquals(url('/config'), $response->getTargetUrl());
    }

    public function testReturnsTrueIfSuperAdmin()
    {
        $user = AuthenticateUser::create();
        $socialiteUser = new \Laravel\Socialite\Two\User;
        $socialiteUser->id = "admin";
        putenv('VALKYRJA_ADMINS=notadmin,'.$socialiteUser->getId());
        $user->setUser($socialiteUser);
        $this->assertTrue($user->isSuperAdmin());
    }

    public function testReturnsFalseIfNotSuperAdmin()
    {
        $user = AuthenticateUser::create();
        $socialiteUser = new \Laravel\Socialite\Two\User;
        $socialiteUser->id = "admin";
        putenv('VALKYRJA_ADMINS=notadmin');
        $user->setUser($socialiteUser);
        $this->assertFalse($user->isSuperAdmin());
    }

    private function getUserWithStrict($strict)
    {
        $user = AuthenticateUser::create();
        $user->setUser(new \Laravel\Socialite\Two\User);
        return $user->get($strict);
    }
}
