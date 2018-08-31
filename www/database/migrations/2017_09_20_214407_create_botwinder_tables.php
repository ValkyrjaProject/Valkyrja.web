<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotwinderTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function up()
    {
        // Not exact copy of Botwinder.discord migration - not creating database for easier migrate refresh
        DB::unprepared(Storage::get('db_botwinder.sql'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blacklist');
        Schema::dropIfExists('channels');
        Schema::dropIfExists('command_channel_options');
        Schema::dropIfExists('command_options');
        Schema::dropIfExists('custom_aliases');
        Schema::dropIfExists('custom_commands');
        Schema::dropIfExists('events');
        Schema::dropIfExists('exceptions');
        Schema::dropIfExists('global_config');
        Schema::dropIfExists('livestream');
        Schema::dropIfExists('localisation');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('nicknames');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('poll_options');
        Schema::dropIfExists('polls');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('server_config');
        Schema::dropIfExists('server_stats');
        Schema::dropIfExists('shards');
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('timer_responses');
        Schema::dropIfExists('timers');
        Schema::dropIfExists('usernames');
        Schema::dropIfExists('users');
        Schema::dropIfExists('votes');
    }
}
