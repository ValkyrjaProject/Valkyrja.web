<?php

namespace App;

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
