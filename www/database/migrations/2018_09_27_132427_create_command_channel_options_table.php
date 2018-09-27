<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommandChannelOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('command_channel_options', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned();
			$table->string('commandid');
			$table->bigInteger('channelid')->unsigned();
			$table->boolean('blacklisted');
			$table->boolean('whitelisted');
			$table->primary(['serverid','commandid','channelid']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('command_channel_options');
	}

}
