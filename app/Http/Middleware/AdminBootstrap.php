<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminBootstrap
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next) : Response
    {
        $request->setUserResolver(function (){
            return \Auth::guard('admin')->user();
        });
        \Log::info('bootstrap admin web site', [$request->user()]);
        return $next($request);
    }
}
