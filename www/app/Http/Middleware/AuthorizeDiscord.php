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
        // TODO: Check if valid Discord token.
        $provider = new Discord([
            'clientId'     => config('discordoauth2.client_id'),
            'clientSecret' => config('discordoauth2.client_secret'),
            'redirectUri'  => url('config')
        ]);

        if (!$request->hasCookie('access_token')) {
            return redirect()->action('ConfigController@login')->with('danger', 'Text here');
        }

        /** @var AccessToken $access_token */
        $access_token = decrypt($request->cookie('access_token'));
        if ($access_token->hasExpired()) {
            $access_token = $provider->getAccessToken('refresh_token', [
                'refresh_token' => $access_token->getRefreshToken()
            ]);

            $response = $next($request);
            $response = $response instanceof Response ? $response : response($response);
            return $response->cookie('access_token', $access_token);
        }

        return $next($request);
    }
}
