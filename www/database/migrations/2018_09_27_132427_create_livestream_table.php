<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLivestreamTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('livestream', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned();
			$table->bigInteger('channelid')->unsigned();
			$table->boolean('type');
			$table->string('channel');
			$table->boolean('islive');
			$table->primary(['channelid','type','channel']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('livestream');
	}

}
