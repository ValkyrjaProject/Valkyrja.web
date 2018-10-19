<?php

use Illuminate\Database\Seeder;

class ChannelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        /** @var \Illuminate\Support\Collection $channels */
        $channels = \Valkyrja\Models\Sample\DiscordChannel::all();
        $channels->slice(count($channels)/2)->each(function ($channel) {
            DB::table('channels')->insert([
                'serverid' => $channel->guild_id,
                'channelid' => $channel->id,
                'muted_until' => now()
            ]);
        });
    }
}
