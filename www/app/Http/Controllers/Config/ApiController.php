<?php

namespace Botwinder\Http\Controllers\Config;

use Botwinder\Http\Controllers\Controller;
use Botwinder\Logic\AuthenticateUserInterface;
use Botwinder\Logic\DiscordDataInterface;
use Botwinder\Policies\ServerConfigPolicy;
use Botwinder\Models\ServerConfig;
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
     * @param AuthenticateUserInterface $user
     * @param ServerConfig $config
     * @return string
     */
    public function guilds(AuthenticateUserInterface $user, ServerConfig $config)
    {
        $guilds = $this->getAuthorizedGuilds($user, $config);
        return $guilds->values()->toJson();
    }

    /**
     * @param AuthenticateUserInterface $user
     * @param ServerConfig $serverConfig
     * @return \Illuminate\Support\Collection
     */
    protected function getAuthorizedGuilds(AuthenticateUserInterface $user, ServerConfig $serverConfig)
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
        })->sortBy('name');
        return $userGuilds;
    }

    /**
     * @param DiscordDataInterface $discord
     * @param ServerConfig $serverConfig
     * @param string $serverId
     * @return array
     */
    public function config(DiscordDataInterface $discord, ServerConfig $serverConfig, $serverId)
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
     * @param AuthenticateUserInterface $user
     * @return array
     */
    public function user(AuthenticateUserInterface $user)
    {
        $user = $user->get();
        return [
            'name' => $user->getName(),
            'avatar' => $user->getAvatar()
        ];
    }
}
