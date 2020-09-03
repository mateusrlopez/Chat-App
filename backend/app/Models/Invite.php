<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $guarded = [];

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function invited()
    {
        return $this->belongsTo(User::class, 'invited_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
