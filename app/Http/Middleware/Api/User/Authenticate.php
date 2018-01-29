<?php

namespace App\Http\Middleware\Api\User;

use App\Auth\AuthManager;
use Closure;

class Authenticate
{
    /**
     * The authentication factory instance.
     *
     * @var AuthManager
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  AuthManager  $auth
     * @return void
     */
    public function __construct()
    {
        $this->auth = app('auth');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try{
            $this->authenticate($guards);
            return $next($request);
        }catch (\Exception $exception){
            return redirect('/api');
        }
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate(array $guards)
    {
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);
                return;
            }
        }

        throw new \Exception('未登录');
    }
}
