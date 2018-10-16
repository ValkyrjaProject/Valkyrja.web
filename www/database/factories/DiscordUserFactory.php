<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Botwinder\Models\Sample\DiscordUser::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomNumber(8),
        'name' => $faker->name,
        'discriminator' => $faker->randomNumber(4, true),
        'avatar' => $faker->imageUrl($width = 640, $height = 640),
        'verified' => $faker->boolean,
        'email' => $faker->email,
    ];
});
