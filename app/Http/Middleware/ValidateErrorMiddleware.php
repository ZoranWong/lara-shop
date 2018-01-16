<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class ValidateErrorMiddleware
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
        try{
            $response = $next($request);
        }catch (ValidationException $exception){
            throw  $exception;
           // $response = back()->withInput()->withErrors($exception->errors());
        }
        return $response;
    }
}
