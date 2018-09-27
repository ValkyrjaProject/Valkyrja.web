<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommandOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('command_options', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned();
			$table->string('commandid');
			$table->boolean('permission_overrides');
			$table->boolean('delete_request');
			$table->boolean('delete_reply')->default(0);
			$table->primary(['serverid','commandid']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('command_options');
	}

}
