<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timers', function(Blueprint $table)
		{
			$table->bigInteger('timerid')->unsigned()->primary();
			$table->bigInteger('serverid')->unsigned();
			$table->bigInteger('channelid')->unsigned();
			$table->boolean('enabled');
			$table->boolean('self_command');
			$table->dateTime('last_triggered');
			$table->dateTime('start_at');
			$table->dateTime('expire_after');
			$table->bigInteger('repeat_interval');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('timers');
	}

}
