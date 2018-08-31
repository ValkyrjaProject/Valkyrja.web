<?php

namespace Botwinder\Http\Controllers;

use Botwinder\Logic\AuthenticateUser;
use Cache;
use Illuminate\Http\Request;
use LaravelRestcord\Discord;
use Socialite;

class OTestingController extends Controller
{
    public function index(Request $request, Discord $discord)
    {
        if (Cache::has('token')) {
            echo 'test';
            $token = $request->session()->get('discord_token');
            $user = Socialite::driver('discord')->userFromToken($token);
            //dd($user);
            //dd([$user, $discord->guilds()]);
        }

        /*if (AuthenticateUser::check()) {
            echo 'Test';
        }
        echo $request->session()->get('discord_token');
        $discord->client();
        dd($discord->guilds());*/

        return "Testing";
    }

    public function test(AuthenticateUser $authenticateUser, Request $request)
    {
        return $authenticateUser->execute($request->has('code'));
    }
}
