<?php

namespace App\Http\Controllers;

use App\Channels;
use App\CustomCommands;
use App\Exceptions\ServerIssueException;
use App\Http\Requests\ConfigRequest;
use App\Roles;
use App\ServerConfig;
use App\DiscordData;
use Illuminate\Http\Request;
use League\OAuth2\Client\Grant\Exception\InvalidGrantException;
use League\OAuth2\Client\Token\AccessToken;
use Response;
use Throwable;

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

    /**
     * Display a listing of the servers.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userId = null;
        if ($request->session()->has('userId')) $userId = $request->session()->get('userId');

        try {
            $discord_data = $this->getDiscordData($request, null, $userId);
        }
        catch (Throwable $e) {
            dd($e);
            $loginController = new LoginController();
            return $loginController->logout($request, 'Unable to authorize you, please login again');
        }

        $user = $discord_data->getCurrentUser();
        $request->session()->put('userId', $user->getId());

        $guilds = $discord_data->getUserGuilds();

        if ($guilds->isEmpty()) {
            $request->session()->flash('messages', ['You do not control any servers! If you do, refresh or logout and login again.']);
        }

        return view('config.display_servers', [
            'user' => $user,
            'guilds' => $guilds
        ]);
    }

    /**
     * Display the specified server.
     *
     * @param ServerConfig $serverConfig
     * @return Response
     */
    /*public function show(BotwinderConfig $serverConfig)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param ServerConfig $serverConfig
     * @param $serverId
     * @return Response
     */
    public function edit(Request $request, ServerConfig $serverConfig, $serverId)
    {
        try {
            $discord_data = $this->getDiscordData($request, $serverId);
        }
        catch (Throwable $e) {
            $loginController = new LoginController();
            return $loginController->logout($request, 'Unable to authorize you, please login again');
        }

        if (!$request->session()->has('userId')) {
            $user = $discord_data->getCurrentUser();
            $request->session()->put('userId', $user->getId());
        }

        if (!$discord_data->canEditConfig($serverId)) {
            abort(403, "Unauthorized access");
        }

        $guildChannels = collect();
        $guildRoles = collect();
        try {
            $guildChannels = $discord_data->getGuildChannels()->keyBy('id');

            $guildRoles = $discord_data->getGuildRoles()->keyBy('id')->filter(function ($role, $key) use (&$guildChannels) {
                // Filter out @everyone
                return !$guildChannels->has($key);
            });
        }
        catch (ServerIssueException $e) {
            abort(404, $e->getMessage());
        }
        catch (Throwable $e) {
            $loginController = new LoginController();
            return $loginController->logout($request, $e->getMessage());
        }
        return view('config.edit', [
            'serverId' => $serverId,
            'serverConfig' => $serverConfig->find($serverId),
            'customCommands' => CustomCommands::where('serverid', $serverId)->get(),
            'roles' => Roles::where('serverid', $serverId)->get(),
            'channels' => Channels::where('serverid', $serverId)->get(),
            'guild' => [
                'roles' => $guildRoles,
                'channels' => $guildChannels
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConfigRequest $request
     * @param $serverId
     * @return Response
     */
    public function update(ConfigRequest $request, $serverId)
    {
        try {
            $discord_data = $this->getDiscordData($request);
        }
        catch (Throwable $e) {
            return $this->logout($request, 'Unable to authorize you, please login again');
        }

        if (!$discord_data->canEditConfig($serverId)) {
            abort(403, "Unauthorized access");
        }

        //TODO: Put validated in own variable, use that instead of request.
        $data = collect($request->validated());
        /** @var ServerConfig $serverConfig */
        $serverConfig = ServerConfig::where('serverid', $serverId)->first();
        if($serverConfig == null) {
            dd('Server does not exist');
        }
        $serverConfig->updateCustomCommands($data->get('custom_commands', []));
        $serverConfig->updateChannels($data->get('channels', []));
        $serverConfig->updateRoles($data->get('roles', []));
        if ($serverConfig->update($data->except([
            'custom_commands',
            'channels',
            'roles'
        ])->all())) {
            return redirect()->route('displayServers')->with('messages', ['Your config was saved!']);
        }
        else {
            return redirect()->back()->with('errors', collect(['Failed to save config! Unknown error']));
        }
    }

    /**
     * @param Request $request
     * @return array|\League\OAuth2\Client\Token\AccessToken|string
     */
    private function accessToken(Request $request)
    {
        $access_token = $request->cookie('access_token');
        $access_token = $this->provider->getAccessToken('refresh_token', [
            'refresh_token' => $access_token->getRefreshToken()
        ]);
        return $access_token;
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

    public function redirectConfig(Request $request)
    {
        if (!$request->input('serverId')) {
            return redirect()->route('displayServers');
        }
        return redirect()->route('editConfig', ['serverID' => $request->input('serverId')]);
    }
}
