<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Valkyrja\Models\Channel::class, function (Faker $faker) {
    return [
        'serverid' => $faker->unique()->randomNumber(8),
        'commandid' =>  $faker->text(16),
        'response' => $faker->sentence(10),
        'description' => $faker->sentence(10)
    ];
});
