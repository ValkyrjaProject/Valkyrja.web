<?php

namespace Botwinder\Http\Middleware;

use Botwinder\Logic\AuthenticateUser;
use Closure;
use Illuminate\Http\Request;
use Throwable;

class IsAuthenticatedUser
{
    /**
     * Add user to session, redirect if not authorized.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = AuthenticateUser::create();
        try {
            $user->get();
        }
        catch (Throwable $e) {
            $user->logout();
            return redirect()->route('login');
        }

        return $next($request);
    }
}
