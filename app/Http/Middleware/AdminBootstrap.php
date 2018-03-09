<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminBootstrap
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return Response | JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->setUserResolver(function (){
            return \Auth::guard('admin')->user();
        });
        return $next($request);
    }
}
