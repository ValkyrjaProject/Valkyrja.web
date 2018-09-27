<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNicknamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nicknames', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('serverid')->unsigned();
			$table->bigInteger('userid')->unsigned();
			$table->string('nickname');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('nicknames');
	}

}
