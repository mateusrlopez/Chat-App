<?php

namespace App\Http\Middleware;

use App\JWT\JWTHandler;
use Closure;
use Illuminate\Auth\AuthenticationException;

class RefreshTokenValidation
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
            JWTHandler::validateRefreshToken($request);
            return $next($request);
        } catch(\Exception $e) {
            throw new AuthenticationException('Invalid refresh token');
        }
    }
}
