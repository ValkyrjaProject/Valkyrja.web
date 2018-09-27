<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shards', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->boolean('taken')->default(0);
			$table->boolean('connecting')->default(0);
			$table->dateTime('time_started');
			$table->bigInteger('memory_used')->default(0);
			$table->bigInteger('threads_active')->default(0);
			$table->bigInteger('server_count')->default(0);
			$table->bigInteger('user_count')->default(0);
			$table->bigInteger('messages_total')->default(0);
			$table->bigInteger('messages_per_minute')->default(0);
			$table->bigInteger('operations_ran')->default(0);
			$table->bigInteger('operations_active')->default(0);
			$table->bigInteger('disconnects')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shards');
	}

}
