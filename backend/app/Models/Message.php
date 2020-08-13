<?php

namespace App\Models;

use App\Events\Message\MessageCreated;
use App\Events\Message\MessageDeleted;
use App\Events\Message\MessageEdited;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = ['links'];
    
    protected $dispatchesEvents = [
        'created' => MessageCreated::class,
        'updated' => MessageEdited::class,
        'deleted' => MessageDeleted::class
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
