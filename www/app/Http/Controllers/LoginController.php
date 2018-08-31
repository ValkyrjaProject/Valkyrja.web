<?php

namespace Botwinder\Http\Controllers;

use Botwinder\Logic\AuthenticateUser;
use Cache;
use Illuminate\Http\Request;
use LaravelRestcord\Discord;
use Socialite;

class LoginController extends Controller
{
    public function login(AuthenticateUser $authenticateUser, Request $request)
    {
        return $authenticateUser->execute($request->has('code'));
    }
}
