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
        factory(Valkyrja\Models\Sample\DiscordGuild::class, 3)
            ->create()
            ->each(function($guild) {
                $guild->channels()->saveMany(factory(Valkyrja\Models\Sample\DiscordChannel::class, 10)->create([
                    'guild_id' => $guild->id
                ]));
                $guild->roles()->saveMany(factory(Valkyrja\Models\Sample\DiscordRole::class, 15)->create([
                    'guild_id' => $guild->id
                ]));
        });
    }
}
