<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class  MiniProgramBootstrap
{
    protected $except = [];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return Response | JsonResponse
     */
    public function handle($request, Closure $next)
    {
        $request->setUserResolver(function (){
            return \Auth::guard('miniProgram')->user();
        });
        return $next($request);
    }
}
