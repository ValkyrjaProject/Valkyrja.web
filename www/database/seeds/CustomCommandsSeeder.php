<?php

use Illuminate\Database\Seeder;

class CustomCommandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('custom_commands')->insert([
            'serverid' => PHP_INT_MAX,
            'commandid' => str_random(8),
            'response' => str_random(32),
            'description' => str_random(32)
        ]);
        DB::table('custom_commands')->insert([
            'serverid' => PHP_INT_MAX,
            'commandid' => str_random(16),
            'response' => str_random(32),
            'description' => str_random(32)
        ]);
    }
}
