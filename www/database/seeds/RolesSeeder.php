<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'serverid' => PHP_INT_MAX,
            'roleid' => random_int(0, PHP_INT_MAX)
        ]);
        DB::table('roles')->insert([
            'serverid' => PHP_INT_MAX,
            'roleid' => random_int(0, PHP_INT_MAX)
        ]);
    }
}
