<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscordUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web__discord_users', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name', 255);
            $table->string('discriminator', 4);
            $table->string('avatar', 1024);
            $table->boolean('verified');
            $table->string('email', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web__discord_users');
    }
}
