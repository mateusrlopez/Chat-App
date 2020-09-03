<?php

namespace App\Models;

use App\Events\Notification\NotificationCreated;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;

class Notification extends DatabaseNotification
{
    protected $guarded = [];
    
    protected $dispatchesEvents = [
        'created' => NotificationCreated::class
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
