<?php

namespace App\Http\Controllers;

use App\ConfigData;
use App\CustomCommands;
use App\DiscordData;
use Exception;
use Illuminate\Http\Request;
use League\OAuth2\Client\Grant\Exception\InvalidGrantException;
use Log;

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
        try {
            if (!$request->session()->has('userId')) {
                throw new Exception('Error authenticating you. Please logout and login again');
            }
            $userId = $request->session()->get('userId');

            $this->discordData = $configController->getDiscordData($request, $serverId, $userId);
            if (!$this->discordData->canEditConfig($serverId)) return response()->json('Unauthorized access', 404);

            $guildChannels = $this->discordData->getGuildChannels()->keyBy('id');
            return json_encode(array_values($guildRoles = $this->discordData->getGuildRoles()
                ->filter(function ($role) use (&$guildChannels) {
                    return !$guildChannels->has($role['id']);
                })
                ->all()));
        }
        catch (InvalidGrantException $e) {
            return response()->json('Error authenticating you. Please logout and login', 403);
        }
        catch (Exception $e) {
            Log::warning($e);
            return response()->json($e->getMessage(), 404);
        }
    }

    public function getChannels(Request $request, ConfigController $configController, $serverId)
    {
        try {
            if (!$request->session()->has('userId')) {
                throw new Exception('Error authenticating you. Please logout and login again');
            }
            $userId = $request->session()->get('userId');

            $this->discordData = $configController->getDiscordData($request, $serverId, $userId);
            if (!$this->discordData->canEditConfig($serverId)) return response()->json('Unauthorized access', 404);

            return json_encode($this->discordData->getGuildChannels());
        }
        catch (InvalidGrantException $e) {
            return response()->json('Error authenticating you. Please logout and login', 403);
        }
        catch (Exception $e) {
            Log::warning($e);
            return response()->json($e->getMessage(), 404);
        }
    }

    public function getData(Request $request, ConfigData $configData, ConfigController $configController, $serverId, $configAttribute)
    {
        try {
            if (!$request->session()->has('userId')) {
                throw new Exception('Error authenticating you. Please logout and login again');
            }
            $userId = $request->session()->get('userId');

            $this->discordData = $configController->getDiscordData($request, $serverId, $userId);
            if (!$this->discordData->canEditConfig($serverId)) return response()->json('Unauthorized access', 404);

            $configData->updateConfigWithId($serverId);
            $this->discordData->getGuildRoles();

            $results = $configData->getAttribute($configAttribute);
            //dd(response()->json(json_encode($results)));
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
            Log::warning($exception);
            return response()->json($exception->getMessage(), 404);
        }
    }

    public function getBotwinderCommands(Request $request)
    {
        return CustomCommands::getBotwinderCommands($request);
    }
}

