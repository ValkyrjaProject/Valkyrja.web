<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Valkyrja\Models\Sample\DiscordRole::class, function (Faker $faker) {
    $id = $faker->unique()->randomNumber(8);
    return [
        'id' => $id,
        'name' => $faker->jobTitle,
        'color' => hexdec($faker->colorName),
        'position' => $faker->unique()->randomNumber(2),
        'guild_id' => $id,
    ];
});
