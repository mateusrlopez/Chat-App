<?php

namespace App\Models;

use App\Filters\StatusFilter;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use Filterable;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
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

    protected static function getFilters()
    {
        return [StatusFilter::class];
    }
}
