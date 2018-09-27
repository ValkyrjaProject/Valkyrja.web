<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomCommandsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_commands', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned();
			$table->string('commandid', 127);
			$table->text('response', 65535)->nullable();
			$table->text('description', 65535)->nullable();
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
		Schema::drop('custom_commands');
	}

}
