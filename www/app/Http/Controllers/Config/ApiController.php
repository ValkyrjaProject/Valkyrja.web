<?php

namespace Botwinder\Http\Controllers\Config;

use Botwinder\Http\Controllers\Controller;
use Botwinder\Logic\AuthenticateUser;
use Botwinder\Logic\DiscordData;
use Botwinder\Policies\ServerConfigPolicy;
use Botwinder\ServerConfig;
use LaravelRestcord\Discord\Guild;

class ApiController extends Controller
{
    /**
     * @var ServerConfigPolicy
     */
    private $policy;

    /**
     * ConfigController constructor.
     * @param ServerConfigPolicy $policy
     */
    public function __construct(ServerConfigPolicy $policy)
    {
        $this->policy = $policy;
    }

    /**
     * @param AuthenticateUser $user
     * @param ServerConfig $config
     * @return string
     */
    public function guilds(AuthenticateUser $user, ServerConfig $config)
    {
        $guilds = $this->getAuthorizedGuilds($user, $config);
        return $guilds->values()->toJson();
    }

    /**
     * @param AuthenticateUser $user
     * @param ServerConfig $serverConfig
     * @return \Illuminate\Support\Collection
     */
    protected function getAuthorizedGuilds(AuthenticateUser $user, ServerConfig $serverConfig)
    {
        $policy = &$this->policy;

        $userGuilds = $user->guilds()->filter(function ($guild) use (&$serverConfig, &$policy, &$user) {
            /** @var Guild $guild */
            // TODO: Make test fail if database is not checked
            if ($policy->isOwner($guild) || $policy->hasPermissions($guild)) {
                $config = $serverConfig->where('serverid', $guild->id())->first();
                if (!is_null($config)) {
                    return $policy->update($user, $config);
                }
            }
            return false;
        });
        return $userGuilds;
    }

    /**
     * @param DiscordData $discord
     * @param ServerConfig $serverConfig
     * @param string $serverId
     * @return array
     */
    public function config(DiscordData $discord, ServerConfig $serverConfig, $serverId)
    {
        $server = $serverConfig->where('serverid', $serverId)->first();
        $guild = $discord->getGuild($serverId);

        if (is_null($guild)) {
            return response()->json(["error" => "Botwinder cannot retrieve guild details!"]);
        }
        $guild->put('config', $server->jsonSerializeApi());
        return $guild->jsonSerialize();
    }

    /**
     * @param AuthenticateUser $user
     * @return array
     */
    public function user(AuthenticateUser $user)
    {
        $user = $user->get();
        return [
            'name' => $user->getName(),
            'avatar' => $user->getAvatar()
        ];
    }
}
