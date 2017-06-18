<?php

namespace App;

use App\Exceptions\EmptyUserException;
use Discord\OAuth\Discord;
use Discord\OAuth\Parts\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use League\OAuth2\Client\Token\AccessToken;

class DiscordData extends Model
{

    private $provider;
    /** @var User $user */
    private $user;
    private $userId;
    /** @var Collection $guilds */
    private $guilds;
    /** @var AccessToken $access_token */
    private $access_token;
    const CONFIG_FOLDER = '../../config/';

    /**
     * DiscordData constructor.
     * @param Discord $provider
     * @param AccessToken $access_token
     * @param null|int $userId
     */
    public function __construct(Discord $provider, AccessToken $access_token, $userId = null)
    {
        parent::__construct();
        $this->access_token = $access_token;
        $this->provider = $provider;
        $this->userId = $userId;
    }

    /**
     * @return User
     * @throws EmptyUserException
     */
    public function getUser()
    {
        if (!isset($this->user)) {
            $this->user = $this->provider->getResourceOwner($this->access_token);
            usleep(200000);
        }
        if ($this->user->getId() == "") {
            throw new EmptyUserException();
        }
        return $this->user;
    }

    /**
     * @return Collection
     */
    public function getGuilds() {
        if (!isset($this->user)) {
            $this->getUser();
        }
        // Get the eligible guilds.
        if (!isset($this->guilds)) {
            $guilds = $this->user->getGuildsAttribute();
            usleep(200000);
            $this->guilds = collect($guilds)->filter(function ($guild) {
                return ($guild->owner || $guild->permissions & 40) && file_exists(self::CONFIG_FOLDER.$guild->id);
            });
        }
        return $this->guilds;
    }

    /**
     * @param $serverId
     * @return bool
     */
    public function canEditGuild($serverId) {
        if (!isset($this->user)) {
            $this->getUser();
        }

        if (!isset($this->guilds)) {
            $this->guilds = $this->getGuilds();
        }

        return collect($this->guilds)->contains(function ($guild) use ($serverId)  {
            return ($serverId == $guild->id) && ($guild->owner || $guild->permissions & 40) && file_exists(self::CONFIG_FOLDER.$guild->id);
        });
    }

}
