<?php

namespace App;

use App\Exceptions\EmptyUserException;
use Cache;
use Discord\OAuth\Discord;
use Discord\OAuth\Parts\Guild;
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
    protected $userFillable = [
        'id',
        'username',
        'email',
        'discriminator',
        'avatar',
        'verified',
        'mfa_enabled',
    ];
    protected $guildFillable = [
        'id',
        'name',
        'icon',
        'owner',
        'permissions',
    ];
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
            if ($this->userId && Cache::has('user_'.$this->userId)) {
                $user = Cache::get('user_'.$this->userId);
                return $this->user = new User($this->provider, $this->access_token, $user);
            }

            $this->user = $this->provider->getResourceOwner($this->access_token);
            $this->userId = $this->user->getId();

            $user = array();
            foreach ($this->userFillable as $name) {
                $user[$name] = $this->user->{$name};
            }

            Cache::add('user_'.$this->user->getId(), $user, 120);
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
            if (Cache::has('user_'.$this->userId.'_guilds')) {
                $userGuilds = Cache::get('user_'.$this->userId.'_guilds');
                $guilds = new Collection();
                foreach ($userGuilds as $guild) {
                    $guilds->push(
                        $this->provider->buildPart(Guild::class, $this->access_token, $guild)
                    );
                }

                return $this->guilds = collect($guilds)->filter(function ($guild) {
                    return ($guild->owner || $guild->permissions & 40) && file_exists(self::CONFIG_FOLDER.$guild->id);
                });
            }
            $guilds = $this->user->getGuildsAttribute();

            $this->guilds = collect($guilds)->filter(function ($guild) {
                return ($guild->owner || $guild->permissions & 40) && file_exists(self::CONFIG_FOLDER.$guild->id);
            });

            $guildsArray = array();
            foreach ($this->guilds as $guild) {
                $guildArray = array();
                foreach ($this->guildFillable as $name) {
                    $guildArray[$name] = $guild->{$name};
                }
                array_push($guildsArray, $guildArray);
            }

            Cache::add('user_'.$this->userId.'_guilds', $guildsArray, 15);
            usleep(200000);
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
