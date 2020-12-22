<?php

namespace App\Observers;

use App\JWT\JWTHandler;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        JWTHandler::generateRefreshToken($user->id);
    }

    public function updated(User $user)
    {
        Cache::forget("user.$user->id");
    }
}
