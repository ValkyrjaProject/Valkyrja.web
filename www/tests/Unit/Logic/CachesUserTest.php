<?php

namespace Tests\Unit\Logic;

use LaravelRestcord\Discord;
use LaravelRestcord\Discord\Guild;
use Valkyrja\Logic\CachesUser;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Two\User;
use \Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class CachesUserTest extends TestCase
{
    private $token = "1";
    private $cacheTime = 2;

    /**
     * @throws \ReflectionException
     */
    public function testUserIsAddedToCache()
    {
        $user = Mockery::spy(User::class);

        Cache::shouldReceive('add')
            ->once()
            ->withArgs([$this->userHashReturn(), $user, $this->cacheTime])
            ->andReturn(true);

        /** @var CachesUser $cachesUser */
        $cachesUser = $this->getMockForTrait(CachesUser::class, [resolve(\Cache::class)]);

        $cachesUser->setCachedUser($this->token, $user);
    }

    public function testUserIsRetrievedFromCache()
    {
        $user = Mockery::spy(User::class);

        Cache::shouldReceive('has')
            ->once()
            ->with($this->userHashReturn())
            ->andReturnTrue();
        Cache::shouldReceive('get')
            ->once()
            ->with($this->userHashReturn())
            ->andReturn($user);

        /** @var CachesUser $cachesUser */
        $cachesUser = $this->getMockForTrait(CachesUser::class, [resolve(\Cache::class)]);

        $response = $cachesUser->getCachedUser($this->token);
        $this->assertEquals($user, $response);
    }

    public function testNoUserReturnsNullFromCache()
    {
        Cache::shouldReceive('has')
            ->once()
            ->with($this->userHashReturn())
            ->andReturnFalse();

        /** @var CachesUser $cachesUser */
        $cachesUser = $this->getMockForTrait(CachesUser::class, [resolve(\Cache::class)]);

        $response = $cachesUser->getCachedUser($this->token);
        $this->assertNull($response);
    }

    /**
     * @throws \ReflectionException
     */
    public function testGuildsIsAddedToCache()
    {
        $guilds = collect();

        Cache::shouldReceive('add')
            ->once()
            ->withArgs([$this->guildsHashReturn(), $guilds->jsonSerialize(), $this->cacheTime])
            ->andReturn(true);

        /** @var CachesUser $cachesUser */
        $cachesUser = $this->getMockForTrait(CachesUser::class, [resolve(\Cache::class)]);

        $cachesUser->setCachedGuilds($this->token, $guilds);
    }

    public function testGetCachedGuildsReturnsCollectionOfGuilds()
    {
        $guilds = [["field" => "value"]];
        $client = Mockery::mock(\LaravelRestcord\Discord\ApiClient::class);
        Discord::setClient($client);
        Cache::shouldReceive('has')
            ->once()
            ->with($this->guildsHashReturn())
            ->andReturnTrue();

        Cache::shouldReceive('get')
            ->once()
            ->with($this->guildsHashReturn())
            ->andReturn($guilds);

        /** @var CachesUser $cachesGuilds */
        $cachesGuilds = $this->getMockForTrait(CachesUser::class, [resolve(\Cache::class)]);

        /** @var Collection $response */
        $response = $cachesGuilds->getCachedGuilds($this->token);
        $this->assertInstanceOf(Collection::class, $response);
        $this->assertCount(1, $response);

        $response->each(function($guild) use (&$guilds) {
            $this->assertInstanceOf(Guild::class, $guild);
            $this->assertEquals($guilds[0]['field'], $guild->field);
        });
    }

    public function testGetCachedGuildsReturnsNullIfCacheIsEmpty()
    {
        Cache::shouldReceive('has')
            ->once()
            ->with($this->guildsHashReturn())
            ->andReturnFalse();

        /** @var CachesUser $cachesGuilds */
        $cachesGuilds = $this->getMockForTrait(CachesUser::class, [resolve(\Cache::class)]);

        /** @var Collection $response */
        $response = $cachesGuilds->getCachedGuilds($this->token);
        $this->assertNull($response);
    }

    private function userHashReturn()
    {
        return "user_" . hash('sha256', $this->token);
    }

    private function guildsHashReturn()
    {
        return "guilds_" . hash('sha256', $this->token);
    }
}
