<?php

namespace Botwinder\Http\Middleware;

use Botwinder\Logic\AuthenticateUser;
use Closure;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (AuthenticateUser::hasDiscordToken()) {
            return redirect('/');
        }

        return $next($request);
    }
}
