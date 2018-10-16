<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscordGuildsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web__discord_guilds', function (Blueprint $table) {
            $table->bigInteger("id")->unsigned();
            $table->string("name", 100);
            $table->string("icon", 2048)->nullable();
            $table->boolean("owner");
            $table->bigInteger("owner_id")->unsigned();
            $table->bigInteger("permissions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web__discord_guilds');
    }
}
