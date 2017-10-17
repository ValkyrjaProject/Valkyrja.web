<?php

namespace App;

use App;
use App\Exceptions\DiscordException;
use App\Exceptions\EmptyUserException;
use App\Exceptions\ServerIssueException;
use Cache;
use Illuminate\Http\RedirectResponse;
use Log;
use Discord\OAuth\Discord;
use Discord\OAuth\Parts\Guild;
use Discord\OAuth\Parts\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use League\OAuth2\Client\Token\AccessToken;
use RestCord\DiscordClient;
use App\Exceptions\EmptyPropertyException;

class DiscordData extends Model
{

    private $provider;
    private $discord;
    /** @var User $user */
    private $user;
    private $userId;
    /** @var Collection $guilds */
    private $guilds;
    /** @var AccessToken $access_token */
    private $access_token;

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
    private $serverId;
    /**
     * @var Collection $serverRoles
     */
    private $serverRoles;
    /**
     * @var Collection $serverChannels
     */
    private $serverChannels;

    /**
     * DiscordData constructor.
     * @param Discord $provider
     * @param AccessToken $access_token
     * @param $serverId
     * @param null|int $userId
     */
    public function __construct(Discord $provider, AccessToken $access_token, $serverId = null, $userId = null)
    {
        parent::__construct();
        $this->access_token = $access_token;
        $this->provider = $provider;
        $this->serverId = $serverId;
        $this->userId = $userId;

        $this->discord = new DiscordClient(['token' => config('discordoauth2.token')]);
    }

    /**
     * @return User
     * @throws EmptyUserException
     */
    public function getCurrentUser()
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

            Cache::add('user_'.$this->user->getId(), $user, 1);
            usleep(200000);
        }
        if ($this->user->getId() == "") {
            throw new EmptyUserException('Error authenticating you. Please logout and login again');
        }
        return $this->user;
    }

    /**
     * @return Collection
     */
    public function getUserGuilds() {
        if (!isset($this->user)) {
            $this->getCurrentUser();
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
                    return ($guild->owner || $guild->permissions & 40) && ServerConfig::find($guild->id);
                });
            }
            $guilds = $this->user->getGuildsAttribute();
            $this->guilds = collect($guilds)->filter(function ($guild) {
                return ($guild->owner || $guild->permissions & 40) && ServerConfig::find($guild->id);
            });

            $guildsArray = array();
            foreach ($this->guilds as $guild) {
                $guildArray = array();
                foreach ($this->guildFillable as $name) {
                    $guildArray[$name] = $guild->{$name};
                }
                array_push($guildsArray, $guildArray);
            }

            Cache::add('user_'.$this->userId.'_guilds', $guildsArray, 1);
            usleep(200000);
        }
        return $this->guilds;
    }

    /**
     * @param $serverId
     * @return bool
     */
    public function canEditConfig($serverId) {
        if (!isset($this->user)) {
            $this->getCurrentUser();
        }

        if (!isset($this->guilds)) {
            $this->guilds = $this->getUserGuilds();
        }

        return collect($this->guilds)->contains(function ($guild) use ($serverId)  {
            return ($serverId == $guild->id) && ($guild->owner || $guild->permissions & 40) && ServerConfig::find($guild->id);
        });
    }

    /**
     * @return RedirectResponse|Collection
     * @throws EmptyPropertyException
     * @throws DiscordException
     * @throws ServerIssueException
     */
    public function getGuildChannels() {
        if (!isset($this->serverId)) throw new EmptyPropertyException('Server ID is not set');

        if (!isset($this->serverChannels)) {
            // For local debugging
            if (App::environment('local')) {
                $serverChannels = collect();
                if (Cache::has('channels')) {
                    $serverChannels = collect(Cache::get('channels'));
                }
                else {
                    for ($i = 0; $i <= 10; $i++) {
                        $tempArray = [];
                        $tempArray['id'] = (string)rand(0, PHP_INT_MAX);
                        $tempArray['name'] = '#'.str_random(rand(4, 16));
                        $serverChannels->push($tempArray);
                    }
                    Cache::add('channels', $serverChannels->all(), 60);
                }
                $this->serverChannels = $serverChannels;
                return $this->serverChannels;
            }
            $rawServerChannels = collect($this->discord->guild->getGuildChannels(['guild.id' => (int)$this->serverId]));

            if ($this->botwinderIsNotOnServer($rawServerChannels)) {
                throw new ServerIssueException("Botwinder is not on the server, if it is, ask in Jefi's Nest");
            }
            elseif ($this->hasNoPermissions($rawServerChannels)) {
                throw new ServerIssueException("Botwinder does not have sufficient permissions.");
            }

            $serverChannels = collect();
            foreach ($rawServerChannels as $serverChannel) {
                if (!isset($serverChannel['type'])) {
                    Log::error('Server channels: '.isset($rawServerChannels['code']) ? $rawServerChannels['code'] : $rawServerChannels);
                    throw new DiscordException('There was an error getting channels from the server. Please try again');
                }
                if ($serverChannel['type'] === 'text') {
                    $tempArray = [];
                    $tempArray['id'] = $serverChannel['id'];
                    $tempArray['name'] = '#'.$serverChannel['name'];

                    $serverChannels->push($tempArray);
                }
            }
            $this->serverChannels = $serverChannels;
        }
        return $this->serverChannels;
    }

    /**
     * @return Collection
     * @throws DiscordException
     * @throws EmptyPropertyException
     * @throws ServerIssueException
     */
    public function getGuildRoles() {
        if (!isset($this->serverId)) throw new EmptyPropertyException('Server ID is not set');

        if (!isset($this->serverRoles)) {
            if (App::environment('local')) {
                $serverRoles = collect();
                if (Cache::has('roles')) {
                    $serverRoles = collect(Cache::get('roles'));
                }
                else {
                    for ($i = 0; $i <= 25; $i++) {
                        $tempArray = [];
                        $tempArray['id'] = (string)rand(0, PHP_INT_MAX);
                        $tempArray['name'] = str_random(rand(4, 24));
                        $serverRoles->push($tempArray);
                    }
                    Cache::add('roles', $serverRoles->all(), 60);
                }
                $this->serverRoles = $serverRoles;
                return $this->serverRoles;
            }
            $rawServerRoles = collect($this->discord->guild->getGuildRoles(['guild.id' => (int)$this->serverId]));

            if ($this->botwinderIsNotOnServer($rawServerRoles)) {
                throw new ServerIssueException("Botwinder is not on the server, if it is, ask in Jefi's Nest");
            }
            elseif ($this->hasNoPermissions($rawServerRoles)) {
                throw new ServerIssueException("Botwinder does not have sufficient permissions.");
            }

            $serverRoles = collect();
            foreach ($rawServerRoles as $serverRole) {
                if (!isset($serverRole['id'])) {
                    Log::error('Server roles: '.isset($rawServerRoles['code']) ? $rawServerRoles['code'] : $rawServerRoles);

                    throw new DiscordException('There was an error getting roles from the server. Please try again');
                }
                $tempArray = [];
                $tempArray['id'] = $serverRole['id'];
                $tempArray['name'] = $serverRole['name'];

                $serverRoles->push($tempArray);
            }
            $this->serverRoles = $serverRoles;
        }
        return $this->serverRoles;
    }

    public function botwinderIsNotOnServer(Collection $receivedData)
    {
        if ($receivedData->has('code') && $receivedData->get('code') == 50001) {
            return true;
        }
        return false;
    }

    /**
     * Clear cache for servers
     * @param $userId
     */
    public static function clearCache($userId)
    {
        Cache::forget('user_'.$userId.'_guilds');
    }

    /**
     * @param null $serverId
     */
    public function setServerId($serverId)
    {
        $this->serverId = $serverId;
    }

    public static function getProvider() {
        return new Discord([
            'clientId'     => config('discordoauth2.client_id'),
            'clientSecret' => config('discordoauth2.client_secret'),
            'redirectUri'  => route('login')
        ]);
    }

    private function hasNoPermissions(Collection $receivedData)
    {
        if ($receivedData->has('code') && $receivedData->get('code') == 50013) {
            return true;
        }
        return false;
    }
}
