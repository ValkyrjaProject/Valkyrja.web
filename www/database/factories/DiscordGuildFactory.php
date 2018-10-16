<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Botwinder\Models\Sample\DiscordGuild::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->randomNumber(8),
        'name' => $faker->company,
        'icon' => $faker->imageUrl($width = 640, $height = 640),
        'owner' => $faker->boolean(),
        'owner_id' => $faker->unique()->randomNumber(8),
        'permissions' => \LaravelRestcord\Discord\Permissions\Permission::MANAGE_GUILD,
    ];
});
