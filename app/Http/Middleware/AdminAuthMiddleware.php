<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuthMiddleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/login',
        '/register',
        'password/reset',
        'password/email',
        'password/reset/*'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        logger('auth admin');
        if(\Auth::guest() && !$this->inExceptArray($request)){
            logger('is guest');
            return redirect('/login');
        }else{
            return $next($request);
        }
    }

    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
