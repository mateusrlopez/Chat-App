<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserChannel extends Pivot
{
    protected $fillable = [
        'user_id', 'channel_id', 'admin'
    ];

    protected $casts = [
        'admin' => true
    ];
}
