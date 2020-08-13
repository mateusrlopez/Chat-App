<?php

namespace App\Http\Controllers\Invite;

use App\Http\Controllers\PrivateController;
use App\Models\Invite;

class InviteController extends PrivateController
{
    public function destroy(Invite $invite)
    {
        $invite->delete();
        return response()->json('', 204);
    }
}
