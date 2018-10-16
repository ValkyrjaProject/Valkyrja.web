<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Botwinder\Models\Sample\DiscordChannel::class, function (Faker $faker) {
    $id = $faker->unique()->randomNumber(8);
    return [
        'id' => $id,
        'name' => str_replace(" ", "-", strtolower($faker->jobTitle)),
        'type' => 0,
        'guild_id' => $id,
    ];
});
