<?php

namespace App\JWT;

interface JWTHandlerInterface
{
    static public function generateAccessToken($userId);

    static public function generateRefreshToken($userId);

    static public function getUserRefreshToken($userId);

    static public function retrieveAuthUser($request);
    
    static public function updateRefreshToken($userId);
    
    static public function validateAccessToken($request);
    
    static public function validateRefreshToken($request);
}