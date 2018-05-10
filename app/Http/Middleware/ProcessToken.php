<?php

namespace App\Http\Middleware;

use App\Helpers\TokenHelper;
use Closure;

class ProcessToken
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
        $tokenKey = "x-token";
        if(!$request->hasHeader($tokenKey)){
            app()->offsetSet("token",null);
            return $next($request);
        }
        $token = $request->header($tokenKey);
        $matchResult = preg_match("/^[0-9a-z]{32}$/",$token);
        if(!$matchResult){
            app()->offsetSet("token",null);
            return $next($request);
        }
        $tokenContent = TokenHelper::get($token);
        if(empty($tokenContent)){
            app()->offsetSet("token",null);
            return $next($request);
        } else {
            app()->offsetSet("token",$tokenContent);
            return $next($request);
        }
    }
}
