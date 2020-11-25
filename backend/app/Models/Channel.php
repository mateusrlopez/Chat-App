<?php

namespace App\Models;

use App\Filters\FriendChannels;
use App\Filters\LimitFilter;
use App\Filters\OrderByFilter;
use App\Filters\WithoutUserFilter;
use App\Filters\PrivateFilter;
use App\Models\Pivot\UserChannel;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use Filterable;

    protected $guarded = [];

    protected $hidden = [
        'updated_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'private' => 'boolean'
    ];

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
        return [
            FriendChannels::class, 
            LimitFilter::class,
            PrivateFilter::class,
            OrderByFilter::class, 
            WithoutUserFilter::class
        ];
    }
}
