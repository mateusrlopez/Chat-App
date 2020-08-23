<?php

namespace App\Models;

use App\Filters\PrivateFilter;
use App\Models\Pivot\UserChannel;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

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

    protected $casts = [
        'private' => 'boolean',
        'tags' => 'array',
        'created_at' => 'date:d/m/Y'
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
        return [PrivateFilter::class];
    }
}
