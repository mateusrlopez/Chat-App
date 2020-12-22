<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\JWT\JWTHandler;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{ 
    public function login(LoginRequest $request)
    {
        if(!list('refreshToken' => $refreshToken, 'accessToken' => $accessToken) = Auth::attempt($request->validated())) {
            return response()->json('Invalid credentials', 401);
        }

        Cache::forget('user.'.Auth::id());

        return response()->json(['accessToken' => $accessToken, 'refreshToken' => $refreshToken, 'user' => Auth::user()]);
    }

    public function me()
    {
        return response()->json(['user' => Cache::remember('user.'.Auth::id(), 3600, fn() => Auth::user())]);
    }

    public function refresh()
    {
        return response()->json(['accessToken' => Auth::refresh()]);
    }

    public function signUp(SignUpRequest $request)
    {
        $validatedData = $request->validated();
        $user = null;
        $refreshToken = null;
        $accessToken = null;

        DB::transaction(function () use ($validatedData, &$user, &$refreshToken, &$accessToken) {    
            $user = User::create(Arr::only($validatedData, ['email', 'name', 'password']));
            $refreshToken = JWTHandler::getUserRefreshToken($user->id);
            $accessToken = JWTHandler::generateAccessToken($user->id);
        });

        return response()->json(['accessToken' => $accessToken, 'refreshToken' => $refreshToken, 'user' => $user], 201);
    }
}
