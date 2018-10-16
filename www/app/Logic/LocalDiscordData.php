<?php

namespace Botwinder\Logic;

use Botwinder\Models\Channel;
use Botwinder\Models\Role;
use Botwinder\Models\Sample\DiscordGuild;
use Botwinder\Models\ServerConfig;
use Illuminate\Support\Collection;
use LaravelRestcord\Discord\Guild;

class LocalDiscordData implements DiscordDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function getGuild($serverId)
    {
        $guild = collect();
        $guild->put('guild', new Guild(DiscordGuild::with(['roles', 'channels'])->find($serverId)->toArray()));
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

    /**
     * @param ServerConfig $serverConfig
     * @param $serverId
     * @return array
     */
    private function getDummyRoles(ServerConfig $serverConfig, $serverId)
    {
        $roles = [];
        $configRoles = $serverConfig->with('roles')->where('serverId', $serverId)->first()->roles()->get();
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
        $configChannels = $serverConfig->with('channels')->where('serverId', $serverId)->first()->channels()->get();
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
}
