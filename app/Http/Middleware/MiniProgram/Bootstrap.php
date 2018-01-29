<?php

namespace App\Http\Middleware\MiniProgram;

use App\Auth\AuthManager;
use Closure;

class Bootstrap
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
        config(['auth.defaults' => [
            'guard' => 'miniProgram',
            'password' => 'users'
        ]]);
        return $next($request);
    }
}
