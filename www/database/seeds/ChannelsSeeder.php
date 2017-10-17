<?php

use Illuminate\Database\Seeder;

class ChannelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('channels')->insert([
            'serverid' => PHP_INT_MAX,
            'channelid' => random_int(0,PHP_INT_MAX),
            'muted_until' => now()
        ]);
        DB::table('channels')->insert([
            'serverid' => PHP_INT_MAX,
            'channelid' => random_int(0,PHP_INT_MAX),
            'muted_until' => now()
        ]);
    }
}
