<?php

use Illuminate\Database\Seeder;

class DiscordSampleGuildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \Illuminate\Support\Collection $guilds */
        $guilds = factory(Botwinder\Models\Sample\DiscordGuild::class, 3)
            ->create()
            ->each(function($guild) {
                $guild->channels()->saveMany(factory(Botwinder\Models\Sample\DiscordChannel::class, 10)->create([
                    'guild_id' => $guild->id
                ]));
                $guild->roles()->saveMany(factory(Botwinder\Models\Sample\DiscordRole::class, 15)->create([
                    'guild_id' => $guild->id
                ]));
        });
    }
}
