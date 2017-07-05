<?php

namespace App\Http\Middleware;

use Closure;
use Discord\OAuth\Discord;
use League\OAuth2\Client\Token\AccessToken;
use Illuminate\Http\Response;

class AuthorizeDiscord
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $provider = new Discord([
            'clientId'     => config('discordoauth2.client_id'),
            'clientSecret' => config('discordoauth2.client_secret'),
            'redirectUri'  => url('config')
        ]);

        if (!$request->hasCookie('access_token')) {
            $request->session()->flush();
            return redirect()->route('login')->withCookie(cookie()->forget('access_token'));
        }
        /** @var AccessToken $access_token */
        $access_token = decrypt($request->cookie('access_token'));
        if ($access_token->hasExpired()) {
            $access_token = $provider->getAccessToken('refresh_token', [
                'refresh_token' => $access_token->getRefreshToken()
            ]);
            $response = $next($request);
            $response = $response instanceof Response ? $response : response($response);
            return $response->cookie('access_token', encrypt($access_token));
        }

        return $next($request);
    }
}
