<?php

namespace App\Models;

use App\Models\Pivot\UserChannel;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'name', 'description', 'tags'
    ];

    protected $casts = [
        'tags' => 'array'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['admin'])
            ->withTimestamps()
            ->using(UserChannel::class);
    }

    public function administrators()
    {
        return $this->users()->wherePivot('admin', true);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
