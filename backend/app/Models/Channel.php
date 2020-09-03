<?php

namespace App\Models;

use App\Filters\WithoutMemberFilter;
use App\Filters\PrivateFilter;
use App\Models\Pivot\UserChannel;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Channel extends Model
{
    use Filterable;

    protected $guarded = [];

    protected $hidden = [
        'updated_at'
    ];

    protected $appends = [
        'online_users_count'
    ];

    protected $casts = [
        'tags' => 'array',
        'private' => 'boolean'
    ];

    public function getOnlineUsersCountAttribute()
    {
        $arrayUsers = json_decode(Redis::get("presence-Channel.{$this->id}:members"));
        return $arrayUsers ? count($arrayUsers) : 0;
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_channel')->withPivot(['admin', 'last_activity'])->withTimestamps()->using(UserChannel::class);
    }

    public function administrators()
    {
        return $this->users()->wherePivot('admin', true);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }

    protected static function getFilters()
    {
        return [PrivateFilter::class, WithoutMemberFilter::class];
    }
}
