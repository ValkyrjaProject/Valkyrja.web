<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExceptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exceptions', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('shardid');
			$table->bigInteger('serverid')->unsigned();
			$table->dateTime('datetime');
			$table->string('message');
			$table->text('stack', 16777215)->nullable();
			$table->string('data');
			$table->string('type')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('exceptions');
	}

}
