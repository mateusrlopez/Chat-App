<?php

namespace App\Models;

use App\Filters\PrivateFilter;
use App\Models\Pivot\UserChannel;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Channel extends Model
{
    use Filterable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $hidden = ['updated_at'];

    protected $appends = ['online_users_count'];

    protected $casts = [
        'private' => 'boolean',
        'tags' => 'array',
        'created_at' => 'date:d/m/Y'
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
        return [PrivateFilter::class];
    }
}
