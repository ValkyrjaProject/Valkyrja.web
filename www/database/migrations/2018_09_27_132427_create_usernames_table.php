<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsernamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usernames', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('serverid')->unsigned();
			$table->bigInteger('userid')->unsigned();
			$table->string('username');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usernames');
	}

}
