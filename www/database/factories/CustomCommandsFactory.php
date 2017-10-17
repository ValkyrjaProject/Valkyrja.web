<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\CustomCommands::class, function (Faker $faker) {
    return [
        'serverid' => PHP_INT_MAX,
        'commandid' => str_random(16),
        'response' => $faker->sentence(26),
        'description' => $faker->sentence(26)
    ];
});
