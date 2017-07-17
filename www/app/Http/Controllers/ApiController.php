<?php

namespace App\Http\Controllers;

use App\ConfigData;
use App\CustomCommands;
use App\DiscordData;
use Exception;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    private $provider;
    private $discordData;

    /**
     * ApiController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        // Initialize Discord provider
        $this->provider = DiscordData::getProvider();
    }

    public function getRoles(Request $request, ConfigController $configController, $serverId)
    {
        $this->discordData = $configController->getDiscordData($request, $serverId, $userId = null);

        $guildChannels = $this->discordData->getGuildChannels()->keyBy('id');
        return json_encode(array_values($guildRoles = $this->discordData->getGuildRoles()
            ->filter(function ($role) use (&$guildChannels) {
                return !$guildChannels->has($role['id']);
            })
            ->all()));
    }

    public function getChannels(Request $request, ConfigController $configController, $serverId)
    {
        $this->discordData = $configController->getDiscordData($request, $serverId, $userId = null);

        return json_encode($this->discordData->getGuildChannels());
    }

    public function getData(Request $request, ConfigData $configData, ConfigController $configController, $serverId, $configAttribute)
    {
        $this->discordData = $configController->getDiscordData($request, $serverId, $userId = null);

        $configData->updateConfigWithId($serverId);
        $this->discordData->getGuildRoles();
        try {
            $results = $configData->getAttribute($configAttribute);
            if ($configAttribute === 'CustomCommands') {
                foreach ($results as &$command) {
                    if (isset($command['RoleWhitelist'])) {
                        foreach ($command['RoleWhitelist'] as &$whitelist) {
                            $whitelist = (string)$whitelist;
                        }
                    }
                    $command['Description'] = trim(str_replace('(Custom non-Botwinder command.)', '', $command['Description']));
                }
            }
            return json_encode($results);
        }
        catch (Exception $exception) {
            return response()->json([ 'error' => 404, 'message' => 'Not found' ], 404);
        }
    }

    public function getBotwinderCommands(Request $request)
    {
        return CustomCommands::getBotwinderCommands($request);
    }
}

