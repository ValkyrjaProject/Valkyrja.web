<?php

namespace App\Http\Middleware;

use App\DiscordData;
use Closure;
use Discord\OAuth\Discord;
use League\OAuth2\Client\Token\AccessToken;

class AuthorizeAdmins
{
    const SPYTEC = 89777099576979456;
    const RHEA = 89805412676681728;
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
            'redirectUri'  => url('config/login')
        ]);

        /** @var AccessToken $access_token */
        $access_token = $request->cookie('access_token');
        $access_token = $provider->getAccessToken('refresh_token', [
            'refresh_token' => $access_token->getRefreshToken()
        ]);

        $discord_data = new DiscordData($provider, $access_token);
        if ((int)$discord_data->getCurrentUser()->getId() === self::SPYTEC || (int)$discord_data->getCurrentUser()->getId() === self::RHEA ) {
            return $next($request);
        }

        return abort(403, "Unauthorized access");
    }
}
