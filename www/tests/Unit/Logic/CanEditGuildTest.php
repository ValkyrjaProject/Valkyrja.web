<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018-04-18
 * Time: 21:45
 */

namespace Tests\Unit\Logic;

use Botwinder\Http\Middleware\CanEditGuild;
use Botwinder\Logic\AuthenticateUser;
use Botwinder\Policies\ServerConfigPolicy;
use Botwinder\ServerConfig;
use Illuminate\Auth\Access\AuthorizationException;
use Mockery;
use Closure;
use Illuminate\Http\Request;
use Tests\TestCase;

class CanEditGuildTest extends TestCase
{
    /** @var Mockery\MockInterface */
    private $user;
    /** @var Mockery\MockInterface */
    private $policy;
    /** @var Mockery\MockInterface */
    private $serverConfig;

    protected function setUp()
    {
        parent::setUp();
        $this->user = Mockery::mock(AuthenticateUser::class);
        $this->policy = Mockery::mock(ServerConfigPolicy::class);
        $this->serverConfig = Mockery::mock(ServerConfig::class);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function testUserCanEditGuild()
    {
        $this->expectNormalUser();

        $this->policy->expects('update')
            ->once()
            ->andReturnTrue();
        $this->serverConfig->expects('find')
            ->once()
            ->getMock();

        $request = new Request;
        $middleware = new CanEditGuild;


        $this->setMiddlewareMocks($middleware);

        $response = $middleware->handle($request, function ($req) {}, $this->serverConfig);
        $this->assertNull($response);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function testUserCannotEditGuild()
    {
        $this->expectNormalUser();

        $this->policy->expects('update')
            ->once()
            ->andReturnFalse();

        $this->serverConfig->expects('find')
            ->once()
            ->getMock();

        $request = new Request;
        $middleware = new CanEditGuild;


        $this->setMiddlewareMocks($middleware);

        $this->expectException(AuthorizationException::class);
        $middleware->handle($request, function ($req) {}, $this->serverConfig);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function testSuperAdminCanEditGuild()
    {
        $this->expectSuperAdmin();

        $this->serverConfig->expects('find')
            ->never()
            ->getMock();

        $request = new Request;
        $middleware = new CanEditGuild;

        $this->setMiddlewareMocks($middleware);


        $response = $middleware->handle($request, function ($req) {}, $this->serverConfig);
        $this->assertNull($response);
    }

    private function expectNormalUser(): void
    {
        $this->policy->expects('before')
            ->once()
            ->with($this->user)
            ->andReturnNull();
    }

    private function expectSuperAdmin(): void
    {
        $this->policy->expects('before')
            ->once()
            ->with($this->user)
            ->andReturnTrue();
    }

    /**
     * @param CanEditGuild $middleware
     */
    private function setMiddlewareMocks($middleware)
    {
        $middleware->setUser($this->user);
        $middleware->setPolicy($this->policy);
    }
}
