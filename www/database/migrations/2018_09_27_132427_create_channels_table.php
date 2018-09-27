<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChannelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('channels', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned();
			$table->bigInteger('channelid')->unsigned()->unique('channelid');
			$table->boolean('ignored')->default(0);
			$table->boolean('temporary')->default(0);
			$table->dateTime('muted_until');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('channels');
	}

}
