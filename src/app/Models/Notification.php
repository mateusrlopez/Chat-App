<?php

namespace App\Models;

use App\Events\Notification\NotificationCreated;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    protected $guarded = [];
    
    protected $dispatchesEvents = [
        'created' => NotificationCreated::class
    ];
}
