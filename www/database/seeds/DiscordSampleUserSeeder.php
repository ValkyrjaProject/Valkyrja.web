<?php

use Illuminate\Database\Seeder;

class DiscordSampleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Botwinder\Models\Sample\DiscordUser::class)->create();
    }
}
