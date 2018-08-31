<?php /** @noinspection ALL */

/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 2018-04-18
 * Time: 21:34
 */

namespace Tests\Unit\Logic;

use Botwinder\Policies\ServerConfigPolicy;
use Botwinder\ServerConfig;
use Illuminate\Support\Collection;
use Laravel\Socialite\Two\User;
use LaravelRestcord\Discord;
use LaravelRestcord\Discord\ApiClient;
use LaravelRestcord\Discord\Guild;
use LaravelRestcord\Discord\Permissions\Permission;
use Mockery;
use Tests\TestCase;

class ServerConfigPolicyTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    private $apiClient;

    /**
     * @var \Mockery\MockInterface
     */
    private $user;

    private const NO_PERMISSIONS = 0;

    /**
     * @var ServerConfig
     */
    private $serverConfig;

    private $serverId;

    protected function setUp()
    {
        parent::setUp();

        $this->serverId = PHP_INT_MAX;

        $this->apiClient = Mockery::mock(ApiClient::class);

        $this->user = Mockery::mock(User::class);

        $this->serverConfig = Mockery::mock(ServerConfig::class);
    }

    public function testGuildOwnerCanEditGuildWithNoPermissions()
    {
        $attributes = [
            "id" => $this->serverId,
            "owner" => true,
            "permissions" => self::NO_PERMISSIONS,
        ];
        $response = $this->editGuildPermissions($attributes);
        $this->assertTrue($response);
    }

    public function testAdministratorCanEditGuild()
    {
        $attributes = [
            "id" => $this->serverId,
            "owner" => false,
            "permissions" => Permission::ADMINISTRATOR,
        ];
        $response = $this->editGuildPermissions($attributes);
        $this->assertTrue($response);
    }

    public function testUserWithManageGuildCanEditGuild()
    {
        $attributes = [
            "id" => $this->serverId,
            "owner" => false,
            "permissions" => Permission::MANAGE_GUILD,
        ];
        $response = $this->editGuildPermissions($attributes);
        $this->assertTrue($response);
    }

    public function testUserCannotEditGuildWithNoPermissions()
    {
        $attributes = [
            "id" => $this->serverId,
            "owner" => false,
            "permissions" => self::NO_PERMISSIONS,
        ];
        $response = $this->editGuildPermissions($attributes);

        $this->assertFalse($response);
    }

    public function testUserCannotEditGuildWithManageRolesPermission()
    {
        $attributes = [
            "id" => $this->serverId,
            "owner" => false,
            "permissions" => Permission::MANAGE_ROLES,
        ];
        $response = $this->editGuildPermissions($attributes);

        $this->assertFalse($response);
    }

    public function testSuperAdminBypassesPolicy()
    {
        $this->user->expects('isSuperAdmin')
            ->once()
            ->andReturnTrue();

        $policy = $this->getServerConfigPolicy();
        $this->assertTrue($policy->before($this->user));
    }

    public function testNormalUserDoesNotBypassPolicy()
    {
        $this->user->expects('isSuperAdmin')
            ->once()
            ->andReturnFalse();

        $policy = $this->getServerConfigPolicy();
        $this->assertNull($policy->before($this->user));
    }

    private function editGuildPermissions($attributes)
    {
        $this->user->expects('get')
            ->andReturn(new User());

        $this->serverConfig->expects('getAttribute')
            ->with('serverid')
            ->andReturn((string)$this->serverId);

        $guild = [new Guild($attributes, $this->apiClient)];

        $discord = Mockery::mock(Discord::class);

        $this->user->expects('guilds')
            ->once()
            ->andReturns(new Collection($guild));

        /** @var ServerConfigPolicy $policy */
        $policy = new ServerConfigPolicy($discord);
        return $policy->update($this->user, $this->serverConfig);
    }

    /**
     * @return ServerConfigPolicy
     */
    private function getServerConfigPolicy()
    {
        $discord = Mockery::spy(Discord::class);

        /** @var ServerConfigPolicy $policy */
        $policy = new ServerConfigPolicy($discord);
        return $policy;
    }
}
