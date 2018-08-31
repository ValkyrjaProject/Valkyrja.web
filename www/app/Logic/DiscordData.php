<?php

namespace Botwinder\Logic;


use App;
use Botwinder\ServerConfig;
use Illuminate\Support\Collection;
use LaravelRestcord\Discord\Channel;
use LaravelRestcord\Discord\Guild;
use LaravelRestcord\Discord\Role;
use RestCord\DiscordClient;

class DiscordData
{
    /**
     * @var DiscordClient
     */
    private $discordClient;


    /**
     * DiscordData constructor.
     * @param DiscordClient $discordClient
     */
    public function __construct(DiscordClient $discordClient)
    {
        $this->discordClient = $discordClient;
    }

    /**
     * @param $serverId
     * @return Collection|null
     */
    public function getGuild($serverId)
    {
        if (App::environment('local')) {
            $guild = $this->createMockGuildData($serverId);
        } else {
            $guild = $this->retrieveGuildData($serverId);
        }
        return $guild;
    }

    /**
     * @param $serverId
     * @return Collection|null
     */
    private function createMockGuildData($serverId)
    {
        $guildData = new Collection();
        $serverConfig = resolve(ServerConfig::class);

        $guild = new Guild([
            'id' => $serverId,
            'name' => uniqid(),
            'icon' => null
        ]);
        $guild->roles = $this->getDummyRoles($serverConfig, $serverId);
        $guild->channels = $this->getDummyChannels($serverConfig, $serverId);
        $guildData->put('guild', $guild);

        return $guildData;
    }

    private function getDummyRoles(ServerConfig $serverConfig, $serverId)
    {
        $roles = [];
        $configRoles = $serverConfig->where('serverId', $serverId)->first()->roles();
        foreach ($configRoles as $role) {
            array_push($roles, $role = new Role([
                'id' => $role->roleid,
                'name' => uniqid(),
                'color' => time() + rand(10, 4000),
                'permissions' => time() + rand(100, 40000),
            ]));
        }
        for ($i = 0; $i < 3; $i++) {
            array_push($roles, new Role([
                'id' => (string) (time() + rand(1, 400)),
                'name' => uniqid(),
                'color' => time() + rand(10, 4000),
                'permissions' => time() + rand(100, 40000),
            ]));
        }
        return $roles;
    }

    private function getDummyChannels(ServerConfig $serverConfig, $serverId)
    {
        $channels = [];
        $configChannels = $serverConfig->where('serverId', $serverId)->first()->channels();
        foreach ($configChannels as $channel) {
            array_push($channels, $channel = new Channel([
                'id' => $channel->roleid,
                'name' => uniqid(),
                'position' => time() + rand(100, 40000),
                'topic' => uniqid(),
            ]));
        }
        for ($i = 0; $i < 3; $i++) {
            array_push($channels, new Channel([
                'id' => (string) (time() + rand(1, 400)),
                'name' => uniqid(),
                'position' => time() + rand(100, 40000),
                'topic' => uniqid(),
            ]));
        }
        return $channels;
    }

    /**
     * @param $serverId
     * @return Collection|null
     */
    private function retrieveGuildData($serverId)
    {
        $guildData = new Collection();
        $guildId = ['guild.id' => (int)$serverId];
        try {
            $guild = $this->discordClient->guild->getGuild($guildId);
            $guild->roles = $this->discordClient->guild->getGuildRoles($guildId);
            $guild->channels = $this->discordClient->guild->getGuildChannels($guildId);
            $guildData->put('guild', $guild);
        } catch (\Exception $exception) {
            report($exception);
            $guildData = null;
        }
        return $guildData;
    }
}