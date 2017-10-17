<?php

namespace App\Http\Controllers;

use App\DiscordData;
use Discord\OAuth\DiscordRequestException;
use Illuminate\Http\Request;

class LoginController extends Controller
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
            return redirect()->route('displayServers');
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

    public function logout(Request $request, $message = 'You are now logged out.')
    {
        dd('logout LoginController: '.$message);
        if ($request->session()->has('userId')) {
            $userId = $request->session()->get('userId');
            DiscordData::clearCache($userId);
        }

        $request->session()->flush();
        return redirect()->route('login')->with('messages', [$message])
            ->withCookie(cookie()->forget('access_token'));
    }
}
