<?php

namespace App\JWT;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JWTHandler implements JWTHandlerInterface
{
    static function generateAccessToken($userId) 
    {
        $payload = [
            'exp' => time() + 86400,
            'iat' => time(),
            'iss' => request()->url(),
            'sub' => $userId
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    static function generateRefreshToken($userId)
    {
        $payload = [
            'iat' => time(),
            'iss' => request()->url(),
            'sub' => $userId
        ];
        
        $token = JWT::encode($payload, env('JWT_SECRET'));
        
        DB::table('refresh_tokens')->insert(['user_id' => $userId, 'token' => $token]);
    }

    static public function getUserRefreshToken($userId)
    {
        return DB::table('refresh_tokens')->whereUserId($userId)->first()->token;
    }

    static public function retrieveAuthUser($request)
    {
        try {
            if(!$tokenHeader = $request->header('Authorization')) {
                throw new \Exception;
            }

            if(!$token = Str::of($tokenHeader)->replace('Bearer ', '')->__toString()) {
                throw new \Exception;
            }

            $userId = JWT::decode($token, env('JWT_SECRET'), ['HS256'])->sub;

            if(!$user = User::find($userId)) {
                throw new \Exception;
            }

            return $user;                
        } catch(\Exception $e) {
            return null;
        }
    }

    static public function updateRefreshToken($userId)
    {
        DB::table('refresh_tokens')->whereUserId($userId)->delete();
        return self::generateRefreshToken($userId);
    }

    static public function validateAccessToken($request)
    {
        if(!$tokenHeader = $request->header('Authorization')) {
            throw new \Exception;
        }

        if(!$token = Str::of($tokenHeader)->replace('Bearer ', '')->__toString()) {
            throw new \Exception;
        }

        if(DB::table('refresh_tokens')->whereToken($token)->first()) {
            throw new \Exception;
        }

        $userId = JWT::decode($token, env('JWT_SECRET'), ['HS256'])->sub;

        if(!User::find($userId)) {
            throw new \Exception;
        }
    }

    static public function validateRefreshToken($request)
    {      
        if(!$tokenHeader = $request->header('Authorization')) {
            throw new \Exception;
        }

        if(!$token = Str::of($tokenHeader)->replace('Bearer ', '')->__toString()) {
            throw new \Exception;
        }

        if(!DB::table('refresh_tokens')->whereToken($token)->first()) {
            throw new \Exception;
        }

        $userId = JWT::decode($token, env('JWT_SECRET'), ['HS256'])->sub;

        if(!User::find($userId)) {
            throw new \Exception;
        }
    }
}