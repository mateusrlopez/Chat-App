<?php

namespace App\Models;

use App\Mail\ResetPasswordMail;
use App\Models\Pivot\UserChannel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function sendPasswordResetNotification($token)
    {
        $url = config('app.url') . "/reset-password?email={$this->email}&token=$token";
        Mail::to($this)->queue(new ResetPasswordMail($url));
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function channels()
    {
        return $this->belongsToMany(Channel::class)->withPivot(['admin', 'last_activity'])->withTimestamps()->using(UserChannel::class);
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function invitesReceived()
    {
        return $this->belongsTo(Invite::class, 'invited_id');
    }

    public function friends()
    {
        return $this->belongsToMany(self::class, 'friendships', null, 'friend_id')->withTimestamps();
    }

    public function friendshipRequestsSent()
    {
        return $this->hasMany(FriendshipRequest::class, 'sender_id');
    }

    public function friendshipRequestsReceived()
    {
        return $this->hasMany(FriendshipRequest::class, 'receiver_id');
    }
}
