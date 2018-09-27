<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('logs', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('messageid')->unsigned();
			$table->bigInteger('serverid')->unsigned();
			$table->bigInteger('channelid')->unsigned();
			$table->bigInteger('userid')->unsigned();
			$table->boolean('type');
			$table->dateTime('datetime');
			$table->text('message', 16777215)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('logs');
	}

}
