<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscordChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web__discord_channels', function (Blueprint $table) {
            $table->bigInteger("id")->unsigned();
            $table->string("name", 100);
            $table->integer("type");
            $table->bigInteger('guild_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web__discord_channels');
    }
}
