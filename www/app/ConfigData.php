<?php

namespace App;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * Used to get default config values from configData.json, insert new values and get all values including updated ones.
 * @package App
 */
class ConfigData extends Model
{
    public $defaultConfig = [];
    public $rawConfig = [];
    private $config_folder = '../../config/';

    function __construct()
    {
        parent::__construct();
        // Storage::get takes from /www/storage/app
        $this->defaultConfig = json_decode(Storage::get('configData.json'), true);
        foreach ($this->defaultConfig as $key => $value) {
            $this->rawConfig[$key] = $this->defaultConfig[$key][0];
        }
    }

    public function getDefaultConfig()
    {
        return $this->defaultConfig;
    }

    public function updateConfigWithId($serverId)
    {
        $file_dir = $this->config_folder.$serverId.'/config.json';
        if (!file_exists($file_dir))
        {
            throw new FileNotFoundException(); //TODO: Create own exception?
        }

        // Get the config
        $server = json_decode(file_get_contents($file_dir), true);
        return $this->updateConfig($server);
    }
    public function updateConfig($config)
    {
        if (!is_array($config))
        {
            return false;
        }
        // If key is the same in Class defaultConfig and parameter, add value from parameter to the first index of class
        foreach ($this->defaultConfig as $key => $value) {
            if (isset($config[$key]))
            {
                if ($this->defaultConfig[$key][1] == "bool"){
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
    public function getConfigValues()
    {
        return $this->defaultConfig;
    }
    public function getRawConfigValues()
    {
        return $this->rawConfig;
    }
}
