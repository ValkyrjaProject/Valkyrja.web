<?php

namespace Tests\Unit\Logic;

use Botwinder\Logic\CachesUser;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Two\User;
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
            ->withArgs([$this->hashReturn(), $user, $this->cacheTime])
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
            ->with($this->hashReturn())
            ->andReturnTrue();
        Cache::shouldReceive('get')
            ->once()
            ->with($this->hashReturn())
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
            ->with($this->hashReturn())
            ->andReturnTrue();
        Cache::shouldReceive('get')
            ->once()
            ->with($this->hashReturn())
            ->andReturnNull();

        /** @var CachesUser $cachesUser */
        $cachesUser = $this->getMockForTrait(CachesUser::class, [resolve(\Cache::class)]);

        $response = $cachesUser->getCachedUser($this->token);
        $this->assertNull($response);
    }

    private function hashReturn()
    {
        return "user_" . hash('sha256', $this->token);
    }
}
