<?php

namespace App\JWT;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use App\JWT\JWTHandler;

class JWTGuard implements Guard
{
    protected $user;
    protected $provider;
    protected $request;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->user = null;
        $this->provider = $provider;
        $this->request = $request;
    }

    public function check()
    {
        return !is_null($this->user());
    }

    public function guest()
    {
        return !$this->check();
    }

    public function user()
    {
        return $this->user ?? JWTHandler::retrieveAuthUser($this->request);
    }

    public function id()
    {
        return $this->check() ? $this->user()->getAuthIdentifier() : null;
    }
    
    public function validate(array $credentials = [])
    {
        $user = $this->provider->retrieveByCredentials($credentials);
        return $user && $this->provider->validateCredentials($user, $credentials);
    }
    
    public function attempt(array $credentials)
    {
        if($this->validate($credentials)) {
            $user = $this->provider->retrieveByCredentials($credentials);
            return $user ? $this->login($user) : false;
        }
        return false;
    }
    
    public function login(Authenticatable $user)
    {
        $accessToken = $this->setUser($user)->accessTokenForUser($user);
        return ['refreshToken' => JWTHandler::getUserRefreshToken($user->id), 'accessToken' => $accessToken];
    }
    
    public function refresh()
    {
        $user = JWTHandler::retrieveAuthUser($this->request);
        return $this->setUser($user)->accessTokenForUser($user);
    }
    
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
        return $this;
    }

    private function accessTokenForUser(Authenticatable $user)
    {
        return JWTHandler::generateAccessToken($user->id);
    }
}