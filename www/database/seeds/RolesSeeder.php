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
            'serverid' => 0,
            'roleid' => random_int(0, PHP_INT_MAX),
            'permission_level' => random_int(1, 5)
        ]);
        DB::table('roles')->insert([
            'serverid' => 0,
            'roleid' => random_int(0, PHP_INT_MAX),
            'permission_level' => random_int(1, 5)
        ]);
        DB::table('roles')->insert([
            'serverid' => 155821059960995840,
            'roleid' => random_int(0, PHP_INT_MAX),
            'permission_level' => random_int(1, 5)
        ]);
        DB::table('roles')->insert([
            'serverid' => 155821059960995840,
            'roleid' => random_int(0, PHP_INT_MAX),
            'permission_level' => random_int(1, 5)
        ]);
    }
}
