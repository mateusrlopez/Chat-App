<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

class UserChannel extends Pivot
{
    protected $casts = [
        'admin' => 'boolean'
    ];

    public function getLastActivityAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
