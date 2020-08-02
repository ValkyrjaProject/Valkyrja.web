<?php

namespace App\Http\Controllers;

use App;
use App\Channels;
use App\CustomCommands;
use App\DiscordData;
use App\Exceptions\ServerIssueException;
use App\Http\Requests\ConfigRequest;
use App\ProfileOptions;
use App\ReactionRoles;
use App\RoleGroups;
use App\Roles;
use App\Partners;
use App\Subscribers;
use App\ServerConfig;
use App\Localisation;
use Carbon\Carbon;
use Discord\OAuth\Parts\Guild;
use Discord\OAuth\Parts\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use League\OAuth2\Client\Grant\Exception\InvalidGrantException;
use League\OAuth2\Client\Token\AccessToken;
use Response;
use Throwable;
use App\TokenSingleton;

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
     * @throws App\Exceptions\EmptyUserException
     */
    public function index(Request $request)
    {
        $userId = null;
        if ($request->session()->has('userId')) {
            $userId = $request->session()->get('userId');
        }

        try {
            $discord_data = $this->getDiscordData(null, $userId);
        } catch (Throwable $e) {
            $loginController = new LoginController();
            return $loginController->logout($request, 'Unable to authorize you, please login again');
        }

        $user = $discord_data->getCurrentUser();
        $request->session()->put('userId', $user->getId());

        $guilds = $discord_data->getUserGuilds();
        if ($guilds->isEmpty()) {
            if (App::environment('local')) {
                $guilds = new Collection();
                $guilds->push(
                    $this->provider->buildPart(Guild::class, TokenSingleton::getToken(),
                        [
                            'id' => "9223372036854775807",
                            'name' => "Test server"
                        ])
                );
            } else {
                $request->session()->flash('messages',
                    ['You do not control any servers! If you do, refresh or logout and login again.']);
            }
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
     * @param String $serverId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     * @throws App\Exceptions\EmptyUserException
     */
    public function edit(Request $request, ServerConfig $serverConfig, $serverId)
    {
        try {
            $discord_data = $this->getDiscordData($serverId);
        } catch (Throwable $e) {
            $loginController = new LoginController();
            return $loginController->logout($request, 'Unable to authorize you, please login again');
        }

        if (!$request->session()->has('userId')) {
            $user = $discord_data->getCurrentUser();
            $request->session()->put('userId', $user->getId());
        }

        if (!$discord_data->canEditConfig($serverId) && !App::environment('local')) {
            abort(403, "Unauthorized access");
        }

        $guildChannels = collect();
        $guildCategories = collect();
        $guildRoles = collect();
        try {
            $guildChannels = $discord_data->getGuildChannels()->keyBy('id');
            $guildCategories = $discord_data->getGuildCategories()->keyBy('id');
            $guildRoles = $discord_data->getGuildRoles()->keyBy('id')->filter(function ($role, $key) use (&$serverId) {
                // Filter out @everyone
                return (string)$key !== $serverId;
            });
        } catch (ServerIssueException $e) {
            abort(404, $e->getMessage());
        } catch (Throwable $e) {
            return redirect()->route("displayServers")->with('messages', [
                'Could not retrieve Discord information. Is Valkyrja on the selected server?'
            ]);
        }
        $localisation = Localisation::where('id', $serverId)->first();
        $isPremium = $this->serverOrUserIsPremium($serverId, $discord_data);
        return view('config.edit', [
            'serverId' => $serverId,
            'serverConfig' => $serverConfig->find($serverId),
            'customCommands' => CustomCommands::where('serverid', $serverId)->get(),
            'roles' => Roles::where('serverid', $serverId)->get(),
            'channels' => Channels::where('serverid', $serverId)->get(),
            'profile_options' => ProfileOptions::where('serverid', $serverId)->get(),
            'role_groups' => RoleGroups::where('serverid', $serverId)->get(),
            'reaction_roles' => ReactionRoles::where('serverid', $serverId)->get(),
            'localisation' => $localisation,
            'localisation_defaults' => Localisation::getDefaults(),
            'guild' => [
                'roles' => $guildRoles,
                'channels' => $guildChannels,
                'categories' => $guildCategories,
            ],
            'isPremium' => $isPremium,
        ]);
    }

    /**
     * @param $serverId
     * @param DiscordData $discordData
     * @return bool
     */
    protected function serverOrUserIsPremium($serverId, $discordData){
        $partner = Partners::find($serverId);
        $ownerIsPremium = Subscribers::find($discordData->getGuildOwnerId());
        return ($partner && $partner->premium) || ($ownerIsPremium && $ownerIsPremium->premium);
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
            $discord_data = $this->getDiscordData();
        } catch (Throwable $e) {
            return $this->logout($request, 'Unable to authorize you, please login again');
        }

        if (!$discord_data->canEditConfig($serverId) && !App::environment('local')) {
            abort(403, "Unauthorized access");
        }
        return DB::transaction(function () use (&$serverId, &$request) {
            //TODO: Put validated in own variable, use that instead of request.
            $data = collect($request->validated());
            /** @var ServerConfig $serverConfig */
            $serverConfig = ServerConfig::where('serverid', $serverId)->first();
            if ($serverConfig == null) {
                dd('Server does not exist');
            }
            $serverConfig->updateCustomCommands($data->get('custom_commands', []));
            $serverConfig->updateChannels($data->get('channels', []));
            $serverConfig->updateProfileOptions($data->get('profile_options', []));
            $serverConfig->updateRoleGroups($data->get('role_groups', []));
            $serverConfig->updateReactionRoles($data->get('reaction_roles', []));
            $serverConfig->updateLocalisation($data->get('localisation', []));

            $roles = $this->getRoles($data);
            $serverConfig->updateRoles($roles);

            $serverConfig->touch();

            if ($serverConfig->update($data->except([
                'custom_commands',
                'channels',
                'roles',
                'levels',
                'profile_options',
                'role_groups',
                'reaction_roles',
                'localisation',
            ])->all())) {
                return redirect()->route('displayServers')->with('messages', ['Your config was saved!']);
            } else {
                return redirect()->back()->with('errors', collect(['Failed to save config! Unknown error']));
            }
        });
    }

    /**
     * @param null $serverId
     * @param null $userId
     * @throws InvalidGrantException
     * @return DiscordData
     */
    public function getDiscordData($serverId = null, $userId = null)
    {
        /** @var AccessToken $access_token */
        $access_token = TokenSingleton::getToken();

        return new DiscordData($this->provider, $access_token, $serverId, $userId);
    }

    public function redirectConfig(Request $request)
    {
        if (!$request->input('serverId')) {
            return redirect()->route('displayServers');
        }
        return redirect()->route('editConfig', ['serverID' => $request->input('serverId')]);
    }

    /**
     * @param Collection $data
     * @return array
     */
    private function getRoles($data): array
    {
        $roles = $data->get('roles', []);
        $levels = $data->get('levels', []);
        foreach ($roles as $roleKey => $role) {
            foreach ($levels as $key => $level) {
                if ($level['roleid'] === $role['roleid']) {
                    $roles[$roleKey]['level'] = $level['level'];
                    array_splice($levels, $key, 1);
                }
            }
        }
        $roles = array_merge($roles, $levels);
        return $roles;
    }
}
