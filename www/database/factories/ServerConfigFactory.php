<?php

use Faker\Generator as Faker;


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Botwinder\Models\ServerConfig::class, function (Faker $faker) {
    return [
        'serverid' => $faker->unique()->randomNumber(18),
        'name' => str_random(10),
        'invite_url' => $faker->url,
        'command_prefix_alt' => '',
        'quickban_reason' => $faker->text(16),
        'log_message_join' => $faker->text(16),
        'log_message_leave' => $faker->text(16),
        'welcome_message' => $faker->text(16),
        'verify_message' => $faker->text(16),
        'base_exp_to_levelup' => $faker->numberBetween(0, PHP_INT_MAX),
        'exp_announce_levelup' => $faker->boolean(),
        'exp_per_message' => $faker->numberBetween(0, PHP_INT_MAX),
        'exp_per_attachment' => $faker->numberBetween(0, PHP_INT_MAX),
        'exp_cumulative_roles' => $faker->boolean()
    ];
});
