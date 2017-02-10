<?php

namespace App\Http\Controllers;

use Crypt;
use Illuminate\Http\Response;
use Session;
use Illuminate\Http\Request;
use \Discord\OAuth\Discord;
use \Discord\OAuth\DiscordRequestException;
use Cookie;

use App\ConfigData as ConfigData;

use App\Http\Requests\ConfigDataValidation as ConfigDataValidation;

class ConfigController extends Controller
{
    /**
     * Relative config from www folder
     */
    private $relative_conf_folder = '../../config/';

    /**
    * Display login screen if not logged in, else show list of servers currently owner of
    */
    public function index(Request $request){

        $provider = new Discord([
            'clientId'     => config('discordoauth2.client_id'),
            'clientSecret' => config('discordoauth2.client_secret'),
            'redirectUri'  => url('config')
        ]);

        // If they have previously authorized
        // TODO: Change to middleware, if authorized and valid, proceed. Otherwise, given they have 'code' GET value, show 'config' view
        if (!$request->hasCookie('access_token'))
        {
            $notAuthorized = $this->notAuthorized($request, $provider);
            if ($notAuthorized !== null) {
                return $notAuthorized;
            }
        }
        // If they have authorized
        if ($request->hasCookie('access_token') && Crypt::decrypt($request->cookie('access_token'))->hasExpired())
        {
            try {
                $refresh_token = Crypt::decrypt($request->cookie('access_token'))->getRefreshToken();
                $token = $provider->getAccessToken('refresh_token', [
                    'refresh_token' => $refresh_token,
                ]);
            } catch (DiscordRequestException $e) {
                Cookie::queue(
                    Cookie::forget('access_token')
                );
                $notAuthorized = $this->notAuthorized($request, $provider);
                if ($notAuthorized !== null) {
                    return $notAuthorized;
                }
            }
        }
        else if($request->hasCookie('access_token'))
        {
          $token = Crypt::decrypt($request->cookie('access_token'));
        }
        else
        {
          $token = $provider->getAccessToken('authorization_code', [
            'code' => $request['code'],
          ]);
        }
        // Get the user object.
        $user = $provider->getResourceOwner($token);
        if($user->id == "") {
            Cookie::queue(
                Cookie::forget('access_token')
            );
            $notAuthorized = $this->notAuthorized($request, $provider);
            if ($notAuthorized !== null) {
                return $notAuthorized;
            }
        }
        // Get the guilds.
        $guilds = $user->guilds;
        $guildsWithManageGuilds = [];

        foreach ($guilds as $guild) {
            $dir = $this->relative_conf_folder.$guild->id;
            if( ($guild->owner || $guild->permissions & 40) && file_exists($dir) )
            {
                array_push($guildsWithManageGuilds, $guild);
            }
        }

        $request->session()->put('userId', Crypt::encrypt($user->id));
        $request->session()->save();

        if($request->hasCookie('access_token'))
        {
            return view('config.display_servers', ['user' => $user, 'guilds' => $guildsWithManageGuilds]);
        }

        $response = new Response(view('config.display_servers', ['user' => $user, 'guilds' => $guildsWithManageGuilds]));
        $response->withCookie(cookie()->forever('access_token', Crypt::encrypt($token)));


        return $response;
    }

    private function notAuthorized(Request $request, Discord $provider)
    {
        // If code is not set
        if (!isset($request['code'])) {
            $authorizationUrl = $provider->getAuthorizationUrl(['scope' => ['identify', 'guilds']]);

            // Get the state generated for you and store it to the session. CSRF protection
            $request->session()->put('oauth2state', $provider->getState());
            $request->session()->save();

            return view('config', ['authorizationUrl' => $authorizationUrl]);
        }
        //CSRF protection
        elseif (empty($request['state']) || ($request['state'] !== $request->session()->get('oauth2state'))) {
            $request->session()->forget('oauth2state');
            abort(403, 'Unauthorized action. CSRF-Prevention');
        }
        return null;
    }
    public function logout(Request $request)
    {
        Cookie::queue(
            Cookie::forget('access_token')
        );
        $request->session()->regenerate();
        return redirect('config');
    }
    /**
    * Load and display config file to the client
    */
    public function displayConfig(Request $request)
    {
        if (!isset($request['serverId']) && $request->old('serverId') == NULL)
        {
            return redirect('config');
        }
        else if (Crypt::decrypt($request->session()->get('userId')) !== $request['userId'] && $request->old('userId') == NULL)
        {
            abort(403, "Unauthorized access");
        }
        else if ($request->old('userId') && Crypt::decrypt($request->session()->get('userId')) !== $request->old('userId'))
        {
            abort(403, "Unauthorized access");
        }

        ini_set('precision', 20); // PHP specific config. Removes scientific notation of big numbers
        if ($request->old('serverId') == NULL) {
            $serverId = $request['serverId'];
        }
        else {
            $serverId = $request->old('serverId');
        }
        $file_dir = $this->relative_conf_folder.$serverId.'/config.json';
        if (!file_exists($file_dir))
        {
            abort(404, "Botwinder isn't added to this server. If it is, please contact Rhea to look into it.");
        }

        if ($request->old('userId') == NULL) {
            $userId = $request['userId'];
        }
        else {
            $userId = $request->old('userId');
        }

        // Get the config
        $server = json_decode(file_get_contents($file_dir), true);

        $configData = new ConfigData;
        $configData->updateConfig($server);

        return view('config.edit', [
            'configData' => $configData->getConfigValues(),
            'userId' => $userId,
            'serverId' => $serverId
        ]);
    }

    /**
    * Receive config settings from client and save to file (TODO: Use ConfigDataValidation)
    */
    public function saveConfig(Request $request)
    {
        // Verify user. Session should be encrypted
        if (Crypt::decrypt($request->session()->get('userId')) !== $request['userId'])
        {
            abort(403, "Unauthorized access");
        }

        ini_set('precision', 20); // PHP specific config. Removes scientific notation of big numbers

        $user_values = $request->all();

        $configData = new ConfigData;

        // Change values to array and set as null if no values exist
        foreach ($configData->getConfigValues() as $key => $value) {
            if ($value[1] == 'list' && isset($user_values[$key]) && $user_values[$key]) {
                $user_values[$key] = explode("\n", $user_values[$key]);
                if (is_array($user_values[$key])) {
                    foreach ($user_values[$key] as $index => $user_value) {
                        $user_values[$key][$index] = (int)$user_value;
                    }
                }
            }
            elseif ($value[1] == 'list' && isset($user_values[$key]) && !$user_values[$key]) {
                $user_values[$key] = NULL;
            }
            elseif ($value[1] == 'int32' && isset($user_values[$key])) {
                $user_values[$key] = ((int)$user_values[$key]) & 0x7FFFFFFF;
            }
            // TODO: Remove temporary solution below. This should be fixed by ConfigDataValidation instead once implemented.
            elseif ($value[1] == 'int' && isset($user_values[$key])) {
                $user_values[$key] = (int)$user_values[$key];
            }
            elseif ($value[1] == 'char' && strlen($user_values[$key]) == 0) {
                $user_values[$key] = (String)$configData->getConfigValues()['CommandCharacter'][0];
            }
        }

        $configData->updateConfig($user_values);

        $server = json_decode(file_get_contents($this->relative_conf_folder.$request['serverId'].'/config.json'), true);
        $rawConfigValues = $configData->getRawConfigValues();

        foreach ($configData->getRawConfigValues() as $key => $value) {
            $server[$key] = $rawConfigValues[$key];
        }

        $file = fopen($this->relative_conf_folder.$request['serverId'].'/config.json', 'w');

        $json_indented_by_4 = json_encode($server, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_NUMERIC_CHECK);
        $json_indented_by_2 = preg_replace('/^(  +?)\\1(?=[^ ])/m', '$1', $json_indented_by_4);
        fwrite($file, $json_indented_by_2);
        fclose($file);

        Session::flash('messages', ['Your config was saved!']);

        return redirect('updates'); // TODO: Redirect to /config
    }
}
