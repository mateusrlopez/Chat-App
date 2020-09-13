<?php

namespace App\Http\Middleware;

use App\JWT\JWTHandler;
use Closure;
use Firebase\JWT\ExpiredException;
use Illuminate\Auth\AuthenticationException;

class JWTAuthentication
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
        try {
            JWTHandler::validateAccessToken($request);
            return $next($request);
        } catch(ExpiredException $e) {
            throw new AuthenticationException('Token has expired');
        } catch (\Exception $e) {
            throw new AuthenticationException('Invalid access token');
        }
    }
}
