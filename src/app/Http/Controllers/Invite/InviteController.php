<?php

namespace App\Http\Controllers\Invite;

use App\Http\Controllers\PrivateController;
use App\Models\Invite;
use Illuminate\Support\Facades\DB;

class InviteController extends PrivateController
{
    public function accept(Invite $invite)
    {
        DB::transaction(function () use ($invite){
            $invite->channel->users()->attach($invite->invited->id);
            $invite->delete();
        });
        return response()->json('', 204);
    }

    public function destroy(Invite $invite)
    {
        $invite->delete();
        return response()->json('', 204);
    }
}
