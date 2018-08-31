<?php

use Faker\Generator as Faker;


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Botwinder\ServerConfig::class, function (Faker $faker) {
    return [
        'serverid' => PHP_INT_MAX,
        'name' => str_random(10),
        'invite_url' => str_random(255),
        'command_prefix_alt' => '',
        'quickban_reason' => str_random(16),
        'log_message_join' => str_random(16),
        'log_message_leave' => str_random(16),
        'welcome_message' => str_random(16),
        'verify_message' => str_random(16),
        'base_exp_to_levelup' => random_int(0, PHP_INT_MAX),
        'exp_announce_levelup' => $faker->boolean(),
        'exp_per_message' => random_int(0, PHP_INT_MAX),
        'exp_per_attachment' => random_int(0, PHP_INT_MAX),
        'exp_cumulative_roles' => $faker->boolean()
    ];
});
