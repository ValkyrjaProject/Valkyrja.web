<?php

use Illuminate\Database\Seeder;

class ServerConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        /** @var \Illuminate\Support\Collection $guilds */
        $guilds = \Botwinder\Models\Sample\DiscordGuild::all();
        $guilds->each(function ($guild) {
            DB::table('server_config')->insert([
                'serverid' => $guild->id,
                'name' => str_random(255),
                'invite_url' => str_random(255),
                'command_prefix_alt' => '',
                'quickban_reason' => str_random(16),
                'log_message_join' => str_random(16),
                'log_message_leave' => str_random(16),
                'welcome_message' => str_random(16),
                'verify_message' => str_random(16),
                'base_exp_to_levelup' => random_int(0, PHP_INT_MAX),
                'exp_announce_levelup' => (bool)random_int(0, 1),
                'exp_per_message' => random_int(0, PHP_INT_MAX),
                'exp_per_attachment' => random_int(0, PHP_INT_MAX),
                'exp_cumulative_roles' => (bool)random_int(0, 1),
            ]);
        });
    }
}
