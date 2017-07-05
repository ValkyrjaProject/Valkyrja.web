<?php

namespace App;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Storage;

/**
 * Used to get default config values from configData.json, insert new values and get all values including updated ones.
 * @package App
 */
class ConfigData extends Model
{
    public $defaultConfig = [];
    public $rawConfig = [];
    public $discordData = [];
    const CONFIG_FOLDER = '../../config/';

    function __construct()
    {
        parent::__construct();
        // Storage::get takes from /www/storage/app
        $this->defaultConfig = json_decode(Storage::get('configData.json'), true);
        foreach ($this->defaultConfig as $key => $value) {
            $this->rawConfig[$key] = $this->defaultConfig[$key][0];
        }
    }

    /**
     * Returns the template config
     * @return array|mixed
     */
    public function getDefaultConfig()
    {
        return $this->defaultConfig;
    }

    /**
     * Sets the template config variables to server settings
     * @param $serverId
     * @return bool
     * @throws FileNotFoundException
     */
    public function updateConfigWithId($serverId)
    {
        $file_dir = self::CONFIG_FOLDER.$serverId.'/config.json';
        if (!file_exists($file_dir))
        {
            throw new FileNotFoundException(); //TODO: Create own exception?
        }

        // Get the config
        $server = json_decode(file_get_contents($file_dir), true);
        return $this->updateConfig($server);
    }

    /**
     * Updates memory stored variables for server
     * @param $config
     * @return bool
     */
    public function updateConfig($config)
    {
        if (!is_array($config)) {
            return false;
        }
        // If key is the same in Class defaultConfig and parameter, add value from parameter to the first index of class
        foreach ($this->defaultConfig as $key => $value) {
            if (isset($config[$key])) {
                if ($this->defaultConfig[$key][1] == "bool") {
                    $this->defaultConfig[$key][0] = (bool)$config[$key];
                    $this->rawConfig[$key] = (bool)$config[$key];
                } else {
                    $this->defaultConfig[$key][0] = $config[$key];
                    $this->rawConfig[$key] = $config[$key];
                }
            }
        }

        return true;
    }

    /**
     * Updates config and saves server config
     * @param $config
     * @param $serverId
     */
    public function saveConfig($config, $serverId) {
        $this->updateConfig($config);
        $this->saveToFile($serverId);
    }

    /**
     * Saves server config to file
     * @param $serverId
     */
    protected function saveToFile($serverId) {
        $server = json_decode(file_get_contents(self::CONFIG_FOLDER.$serverId.'/config.json'), FILE_USE_INCLUDE_PATH);
        $rawConfigValues = $this->rawConfig;

        foreach ($rawConfigValues as $key => $value) {
            $server[$key] = $rawConfigValues[$key];
        }

        $file = fopen(self::CONFIG_FOLDER.$serverId.'/config.json', 'w');

        $json_indented_by_4 = json_encode($server, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);
        $json_indented_by_2 = preg_replace('/^(  +?)\\1(?=[^ ])/m', '$1', $json_indented_by_4);
        fwrite($file, $json_indented_by_2);
        fclose($file);
    }

    /**
     * Returns default config with type and value
     * @return array|mixed
     */
    public function getConfigValues()
    {
        return $this->defaultConfig;
    }

    /**
     * Returns raw config with value only
     * @return array
     */
    public function getRawConfigValues()
    {
        return $this->rawConfig;
    }

    /**
     * Filters through list of roles and puts them in available/selected list
     * @param Collection $serverRoles
     * @return array
     */
    public function filterGuildRoles(Collection $serverRoles)
    {
        $roleTypes = [
            "RoleIDsAdmin",
            "RoleIDsModerator",
            "RoleIDsSubModerator",
            "RoleIDsMember",
            "PublicRoleIDs"
        ];
        foreach ($roleTypes as $role) {
            $this->discordData[$role] = $this->filterRoleData($serverRoles, $role);
        }
        return $this->discordData;
    }

    /**
     * Filters through roles and puts them in their respective available/selected list
     * @param Collection $serverRoles
     * @param $name
     * @return array|Collection
     */
    private function filterRoleData(Collection $serverRoles, $name) {
        if (!isset($this->defaultConfig[$name][0])) {
            return ["available" => array_values($serverRoles->all())];
        }
        elseif (!is_array($this->defaultConfig[$name][0])) {
            $roles = $serverRoles->partition(function ($row) use (&$name) {
                return $row['id'] == $this->defaultConfig[$name][0];
            });
        }
        else
        {
            $roles = $serverRoles->partition(function ($row) use (&$name) {
                return in_array($row['id'], $this->defaultConfig[$name][0]);
            });
        }

        $roles["selected"] = array_values($roles->get(0)->all());
        unset($roles[0]);
        $roles["available"] = array_values($roles->get(1)->all());
        unset($roles[1]);

        return $roles;
    }

    /**
     * Filters through list of roles and puts them in available/selected list
     * @param Collection $serverChannels
     * @return array
     */
    public function filterGuildChannels(Collection $serverChannels)
    {
        $channelTypes = [
            "ModChannelIgnore"
        ];
        foreach ($channelTypes as $channel) {
            $this->discordData[$channel] = $this->filterChannelData($serverChannels, $channel);
        }
        return $this->discordData;
    }

    /**
     * Filters through roles and puts them in their respective available/selected list
     * @param Collection $serverChannels
     * @param $name
     * @return array|Collection
     */
    private function filterChannelData(Collection $serverChannels, $name) {
        if (!isset($this->defaultConfig[$name][0])) {
            return ["available" => array_values($serverChannels->all())];
        }
        elseif (!is_array($this->defaultConfig[$name][0])) {
            $channels = $serverChannels->partition(function ($row) use (&$name) {
                return $row['id'] == $this->defaultConfig[$name][0];
            });
        }
        else
        {
            $channels = $serverChannels->partition(function ($row) use (&$name) {
                return in_array($row['id'], $this->defaultConfig[$name][0]);
            });
        }

        $channels["selected"] = array_values($channels->get(0)->all());
        unset($channels[0]);
        $channels["available"] = array_values($channels->get(1)->all());
        unset($channels[1]);

        return $channels;
    }

    /**
     * @return array
     */
    public function getDiscordData(): array
    {
        return $this->discordData;
    }

}
