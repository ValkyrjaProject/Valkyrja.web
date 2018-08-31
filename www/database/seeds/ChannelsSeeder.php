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
            'serverid' => 0,
            'channelid' => random_int(0,PHP_INT_MAX),
            'muted_until' => now()
        ]);
        DB::table('channels')->insert([
            'serverid' => 0,
            'channelid' => random_int(0,PHP_INT_MAX),
            'muted_until' => now()
        ]);
        DB::table('channels')->insert([
            'serverid' => 155821059960995840,
            'channelid' => random_int(0,PHP_INT_MAX),
            'muted_until' => now()
        ]);
        DB::table('channels')->insert([
            'serverid' => 155821059960995840,
            'channelid' => random_int(0,PHP_INT_MAX),
            'muted_until' => now()
        ]);
    }
}
