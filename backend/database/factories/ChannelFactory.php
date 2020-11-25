<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2),
        'owner_id' => 1,
        'description' => $faker->text,
        'private' => $faker->boolean(),
        'tags' => $faker->words(5),
        'channel_picture_url' => $faker->imageUrl
    ];
});
