<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Botwinder\Models\Channel::class, function (Faker $faker) {
    return [
        'serverid' => $faker->unique()->randomNumber(18),
        'commandid' =>  $faker->text(16),
        'response' => $faker->sentence(10),
        'description' => $faker->sentence(10)
    ];
});
