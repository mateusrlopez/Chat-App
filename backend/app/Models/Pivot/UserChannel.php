<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserChannel extends Pivot
{
    protected $casts = [
        'admin' => 'boolean'
    ];
}
