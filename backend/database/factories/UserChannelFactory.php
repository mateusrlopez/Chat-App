<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pivot\UserChannel;
use Faker\Generator as Faker;

$factory->define(UserChannel::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'channel_id' => 1,
        'admin' => 0
    ];
});
