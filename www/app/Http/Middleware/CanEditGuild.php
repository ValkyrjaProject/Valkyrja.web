<?php

namespace Botwinder\Http\Middleware;

use Botwinder\Logic\AuthenticateUser;
use Botwinder\Policies\ServerConfigPolicy;
use Botwinder\ServerConfig;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;

class CanEditGuild
{
    private $user;
    private $policy;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param ServerConfig $serverConfig
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next, ServerConfig $serverConfig)
    {
        /** @var AuthenticateUser $user */
        $user = $this->getUser();

        /** @var ServerConfigPolicy $policy */
        $policy = $this->getPolicy();
        if (is_null($policy->before($user))) {
            $canEdit = $policy->update($user, $serverConfig->find($request->route('serverId')));
            if (!$canEdit) {
                throw new AuthorizationException("Not authorized to edit guild");
            }
        }
        return $next($request);
    }

    private function getUser()
    {
        if (is_null($this->user)) {
            return $this->user = resolve(AuthenticateUser::class);
        }
        return $this->user;
    }

    /**
     * @param AuthenticateUser $user
     */
    public function setUser($user = null): void
    {
        $this->user = $user;
    }

    private function getPolicy()
    {
        if (is_null($this->policy)) {
            return $this->policy = resolve(ServerConfigPolicy::class);
        }
        return $this->policy;
    }

    /**
     * @param mixed $policy
     */
    public function setPolicy($policy): void
    {
        $this->policy = $policy;
    }
}
