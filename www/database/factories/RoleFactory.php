<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\Botwinder\Role::class, function (Faker $faker) {
    return [
        'serverid' => PHP_INT_MAX,
        'roleid' => $faker->unique()->randomNumber(18),
        'permission_level' => $faker->numberBetween(0, PHP_INT_MAX),
        'public_id' => $faker->boolean(),
        'logging_ignored' => $faker->boolean(),
        'antispam_ignored' => $faker->boolean(),
        'level' => $faker->numberBetween(0, PHP_INT_MAX)
    ];
});
