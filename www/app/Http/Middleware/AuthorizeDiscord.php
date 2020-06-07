<?php

namespace App\Http\Middleware;

use App\DiscordData;
use Closure;
use Discord\OAuth\Discord;
use Discord\OAuth\DiscordRequestException;
use Exception;
use Illuminate\Http\Request;
use League\OAuth2\Client\Token\AccessToken;
use Illuminate\Http\Response;
use Log;
use App\TokenSingleton;

class AuthorizeDiscord
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $provider = DiscordData::getProvider();

        if (!$request->hasCookie('access_token')) {
            return $this->redirectToLogin($request);
        }
        /** @var AccessToken $access_token */
        $access_token = $request->cookie('access_token');

        try {
            if (is_string($access_token)) {
                if (!(($access_token = decrypt($access_token)) instanceof AccessToken)) {
                    Log::warning('access_token is a string: '.$access_token);
                    return $this->redirectToLogin($request, 'Err1. There was an error authenticating you. Please login again');
                }
            }
        }
        catch (Exception $e) {
            Log::warning('access_token is a string (could not decrypt): '.$e);
            return $this->redirectToLogin($request, 'Err2. There was an error authenticating you. Please login again');
        }
        if ($access_token->hasExpired()) {
            try {
                $access_token = $provider->getAccessToken('refresh_token', [
                    'refresh_token' => $access_token->getRefreshToken()
                ]);
            }
            catch (DiscordRequestException $e) {
                Log::warning($e);
                return $this->redirectToLogin($request, 'Err3. There was an error authenticating you. Please login again.');
            }
            $response = $next($request);
            $response = $response instanceof Response ? $response : response($response);
            return $response->cookie('access_token', $access_token);
        }

        TokenSingleton::setToken($access_token);

        return $next($request);
    }

    protected function redirectToLogin(Request $request, $message = '')
    {
        $request->session()->flush();
        $redirect = redirect()
            ->route('login')
            ->withCookie(cookie()->forget('access_token'));
        if ($message) {
            return $redirect->with('messages', [$message]);
        }
        return $redirect;
    }
}
