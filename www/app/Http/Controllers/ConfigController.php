<?php

namespace App\Http\Controllers;

use App\CustomCommands;
use App\DiscordData;
use App\Exceptions\ServerIssueException;
use Exception;
use Illuminate\Http\RedirectResponse;
use League\OAuth2\Client\Grant\Exception\InvalidGrantException;
use League\OAuth2\Client\Token\AccessToken;
use Illuminate\Http\Request;
use \Discord\OAuth\DiscordRequestException;

use App\ConfigData as ConfigData;

use App\Http\Requests\ConfigDataValidation as ConfigDataValidation;
use Response;

class ConfigController extends Controller
{
    private $provider;

    /**
     * ConfigController constructor.
     * @internal param string $relative_conf_folder
     */
    public function __construct()
    {
        $this->provider = DiscordData::getProvider();
        ini_set('precision', 20); // PHP specific config. Removes scientific notation of big numbers
    }

    public function login(Request $request)
    {
        // If code is not set
        if ($request->hasCookie('access_token')) {
            return redirect()->action('ConfigController@displayServers');
        }
        if (!isset($request['code'])) {
            $authorizationUrl = $this->provider->getAuthorizationUrl(['scope' => ['identify', 'guilds']]);

            // Get the state generated for you and store it to the session. CSRF protection
            $request->session()->put('oauth2state', $this->provider->getState());

            return view('config', ['authorizationUrl' => $authorizationUrl]);
        } //CSRF protection
        elseif ((empty($request['state']) || ($request['state'] !== $request->session()->get('oauth2state')))) {
            $request->session()->forget('oauth2state');
            abort(403, 'Unauthorized action. CSRF-Prevention');
        }
        $response = redirect();
        try {
            $access_token = $this->provider->getAccessToken('authorization_code', [
                'code' => $request['code'],
            ]);
            $response = $response->route('displayServers')->cookie('access_token', $access_token)->with('messages', ['You are now logged in!']);
        } catch (DiscordRequestException $e) {
            $response = $response->route('login')->with('messages', ['There was an error logging you in, try again.']);
        }
        return $response;
    }

    /**
     * Display login screen if not logged in, else show list of servers currently owner of
     * @param Request $request
     * @return Controller|\Illuminate\Http\RedirectResponse
     */
    public function displayServers(Request $request)
    {
        $userId = null;
        if ($request->session()->has('userId')) $userId = $request->session()->get('userId');

        $discord_data = $this->getDiscordData($request, null, $userId);

        $user = $discord_data->getCurrentUser();
        $request->session()->put('userId', $user->getId());

        $guilds = $discord_data->getUserGuilds();
        if ($guilds->isEmpty()) {
            $request->session()->flash('messages', ['You do not control any servers! If you do, refresh or logout and login again.']);
        }

        return view('config.display_servers', ['user' => $discord_data->getCurrentUser(), 'guilds' => $guilds]);
    }

    public function logout(Request $request, $message = 'You are now logged out.')
    {
        if ($request->session()->has('userId')) {
            $userId = $request->session()->get('userId');
            DiscordData::clearCache($userId);
        }

        $request->session()->flush();
        return redirect()->action('ConfigController@login')->with('messages', [$message])
            ->withCookie(cookie()->forget('access_token'));
    }

    public function redirectConfig(Request $request)
    {
        if (!$request->input('serverId')) {
            return redirect()->route('displayServers');
        }
        return redirect()->route('editConfig', ['serverID' => $request->input('serverId')]);
    }

    /**
     * Load and display config file to the client
     * @param Request $request
     * @param ConfigData $configData
     * @param $serverId
     * @return Controller|\Illuminate\Http\RedirectResponse
     */
    public function displayConfig(Request $request, ConfigData $configData, $serverId)
    {
        $discord_data = $this->getDiscordData($request, $serverId);

        if (!$request->session()->has('userId')) {
            $user = $discord_data->getCurrentUser();
            $request->session()->put('userId', $user->getId());
        }

        if (!$discord_data->canEditGuild($serverId)) {
            abort(403, "Unauthorized access");
        }

        $configData->updateConfigWithId($serverId);
        $guildChannels = collect();
        $guildRoles = collect();
        try {
            $guildChannels = $discord_data->getGuildChannels()->keyBy('id');

            $guildRoles = $discord_data->getGuildRoles()->keyBy('id')->filter(function ($role, $key) use (&$guildChannels) {
                return !$guildChannels->has($key);
            });
        }
        catch (ServerIssueException $e) {
            abort(404, $e->getMessage());
        }
        catch (Exception $e) {
            return $this->logout($request, $e->getMessage());
        }

        $configData->filterGuildRoles($guildRoles);
        $configData->filterGuildChannels($guildChannels);

        return view('config.edit', [
            'configData' => $configData->getConfigValues(),
            'serverId' => $serverId,
            'discordData' => $configData->getDiscordData(),
            'guild' => [
                'roles' => $guildRoles,
                'channels' => $guildChannels
            ]
        ]);
    }


    /**
     * Receive config settings from client and save to file (TODO: Use ConfigDataValidation)
     * @param Request $request
     * @param ConfigData $configData
     * @param CustomCommands $customCommands
     * @param $serverId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveConfig(Request $request, ConfigData $configData, CustomCommands $customCommands, $serverId)
    {
        $discord_data = $this->getDiscordData($request);

        if (!$discord_data->canEditGuild($serverId)) {
            abort(403, "Unauthorized access");
        }

        $user_values = $request->all();

        // TODO: Remove temporary solution below. This should be fixed by ConfigDataValidation instead once implemented.
        // Change values to array and set as null if no values exist
        foreach ($configData->getConfigValues() as $key => $value) {
            if ($value[1] == 'list' && isset($user_values[$key]) && is_array($user_values[$key]) && $user_values[$key]) {
                if ($key === 'CustomCommands') {
                    $user_values[$key] = $customCommands->validate(collect($user_values[$key]));
                    // format and validate custom commands
                    continue;
                }
                foreach ($user_values[$key] as $index => $user_value) {
                    $user_values[$key][$index] = (int)$user_value;
                }
            }
            elseif ($value[1] == 'list' && isset($user_values[$key])) {
                $user_values[$key] = NULL;
            }
            elseif ($value[1] == 'int32' && isset($user_values[$key])) {
                $user_values[$key] = ((int)$user_values[$key]) & 0x7FFFFFFF;
            }
            elseif ($value[1] == 'int' && isset($user_values[$key])) {
                $user_values[$key] = (int)$user_values[$key];
            } // Set to default value if it's empty
            elseif ($key == 'CommandCharacter' && strlen($user_values[$key]) == 0) {
                $user_values[$key] = (String)$configData->getConfigValues()['CommandCharacter'][0];
            }
        }

        $configData->saveConfig($user_values, $serverId);


        return redirect()->route('displayServers')->with('messages', ['Your config was saved!']);
    }

    /**
     * @param Request $request
     * @param null $serverId
     * @param null $userId
     * @throws InvalidGrantException
     * @return DiscordData
     */
    public function getDiscordData(Request $request, $serverId = null, $userId = null)
    {
        /** @var AccessToken $access_token */
        $access_token = $request->cookie('access_token');
        $access_token = $this->provider->getAccessToken('refresh_token', [
            'refresh_token' => $access_token->getRefreshToken()
        ]);

        return new DiscordData($this->provider, $access_token, $serverId, $userId);
    }
}
