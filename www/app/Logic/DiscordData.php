<?php

namespace Botwinder\Logic;

use App;
use Illuminate\Support\Collection;
use RestCord\DiscordClient;

class DiscordData implements DiscordDataInterface
{
    /**
     * @var DiscordClient
     */
    private $discordClient;

    /**
     * DiscordData constructor.
     */
    public function __construct()
    {
        $this->setDiscordClient(resolve(DiscordClient::class));
    }

    /**
     * @param DiscordClient $discordClient
     */
    private function setDiscordClient(DiscordClient $discordClient): void
    {
        $this->discordClient = $discordClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getGuild($serverId)
    {
        return $this->retrieveGuildData($serverId);
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
