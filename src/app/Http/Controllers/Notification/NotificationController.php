<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\PrivateController;
use App\Models\Notification;

class NotificationController extends PrivateController
{
    public function update(Notification $notification) 
    {
        $notification->markAsRead();
        return response()->json('', 204);
    }
}
