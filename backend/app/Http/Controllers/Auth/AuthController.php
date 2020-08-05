<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SingUpRequest;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{ 

    public function __construct()
    {
        $this->middleware('auth')->only('logout');
    }

    public function login(LoginRequest $request)
    {
        if(!$token = Auth::attempt($request->validated()))
            return response()->json('Invalid credentials', 422);

        return response()->json(['token' => $token, 'user' => Auth::user()]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json('', 204);
    }

    public function signUp(SingUpRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create(Arr::only($validatedData, ['email', 'name', 'password']));
        $token = Auth::login($user);

        return response()->json(['token' => $token, 'user' => $user], 201);
    }
}
