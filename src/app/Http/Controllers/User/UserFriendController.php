<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\PrivateController;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserFriendController extends PrivateController
{
    public function index(User $user) 
    {
        return $user->friends()->orderBy('name')->get();
    }

    public function destroy(User $user, User $friend)
    {
        DB::transaction(function () use ($user, $friend) {
            $user->friends()->detach($friend->id);
            $friend->friends()->detach($user->id);
        });

        return response()->json('', 204);
    }
}
