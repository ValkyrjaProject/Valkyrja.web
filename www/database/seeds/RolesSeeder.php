<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        /** @var \Illuminate\Support\Collection $roles */
        $roles = \Valkyrja\Models\Sample\DiscordRole::all();
        $roles->slice(count($roles)/2)->each(function ($role) {
            DB::table('roles')->insert([
                'serverid' => $role->guild_id,
                'roleid' => $role->id,
                'permission_level' => random_int(1, 5)
            ]);
        });
    }
}
