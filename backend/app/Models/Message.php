<?php

namespace App\Models;

use App\Events\Message\MessageCreated;
use App\Events\Message\MessageDeleted;
use App\Events\Message\MessageEdited;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    
    protected $dispatchesEvents = [
        'created' => MessageCreated::class,
        'deleted' => MessageDeleted::class,
        'updated' => MessageEdited::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
