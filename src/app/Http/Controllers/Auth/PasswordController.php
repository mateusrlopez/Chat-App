<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\JWT\JWTHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    public function requestPasswordReset(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);

        $response = $this->broker()->sendResetLink($request->only(['email']));

        return $response === Password::RESET_LINK_SENT ? 
            response()->json('Password reset email sent sucessfully') : 
            response()->json(['errors' => 'Error sending reset mail, check if you haven\'t requested already'], 400);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $authUser = new \stdClass;
        $validatedData = $request->validated();

        $response = $this->broker()->reset(Arr::only($validatedData, ['email', 'password', 'token']), function($user, $password) use (&$authUser) {
            $user->password = $password;
            $user->save();
            $authUser = $user;
        });

        JWTHandler::updateRefreshToken($authUser->id);

        return $response === Password::PASSWORD_RESET ?
            response()->json('Password reseted successfully') :
            response()->json(['errors' => 'Error during password reset'], 400);
    }

    private function broker()
    {
        return Password::broker();
    }
}
