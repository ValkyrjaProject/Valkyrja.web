<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Botwinder\CustomCommand::class, function (Faker $faker) {
    return [
        'serverid' => PHP_INT_MAX,
        'commandid' =>  $faker->unique()->regexify('[a-z]{5,16}'),
        'response' => $faker->sentence(10),
        'description' => $faker->sentence(10)
    ];
});
