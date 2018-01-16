<?php

namespace App\Http\Middleware;

use Closure;

class  MiniProgramBootstrap
{
    protected $except = [];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) : mixed
    {
        config(['auth.defaults' => [
            'guard' => 'miniProgram',
            'password' => 'users'
        ]]);
        return $next($request);
    }
}
