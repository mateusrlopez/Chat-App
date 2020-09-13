<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\JWT\JWTHandler;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{ 
    public function login(LoginRequest $request)
    {
        if(!list('refreshToken' => $refreshToken, 'accessToken' => $accessToken) = Auth::attempt($request->validated())) {
            return response()->json('Invalid credentials', 401);
        }
        
        return response()->json(['access_token' => $accessToken, 'refresh_token' => $refreshToken, 'user' => Auth::user()]);
    }

    public function refresh()
    {
        return response()->json(['access_token' => Auth::refresh()]);
    }

    public function signUp(SignUpRequest $request)
    {
        $validatedData = $request->validated();
        $user = null;
        $refreshToken = null;
        $accessToken = null;

        DB::transaction(function () use ($validatedData, &$user, &$refreshToken, &$accessToken) {    
            $user = User::create(Arr::only($validatedData, ['email', 'name', 'password']));
            $refreshToken = JWTHandler::generateRefreshToken($user->id);
            $accessToken = JWTHandler::generateAccessToken($user->id);
        });

        return response()->json(['access_token' => $accessToken, 'refresh_token' => $refreshToken, 'user' => $user], 201);
    }
}
