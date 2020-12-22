<?php

namespace App\Http\Controllers\FriendshipRequest;

use App\Http\Controllers\PrivateController;
use App\Models\FriendshipRequest;
use Illuminate\Support\Facades\DB;

class FriendshipRequestController extends PrivateController
{
    public function accept(FriendshipRequest $friendshipRequest)
    {
        DB::transaction(function () use ($friendshipRequest) {
            $friendshipRequest->sender->friends()->attach($friendshipRequest->receiver);
            $friendshipRequest->receiver->friends()->attach($friendshipRequest->sender);
            $friendshipRequest->delete();
        });

        return response()->json('', 204);
    }

    public function destroy(FriendshipRequest $friendshipRequest)
    {
        $friendshipRequest->delete();
        return response()->json('', 204);
    }
}
