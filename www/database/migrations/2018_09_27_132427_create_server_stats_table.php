<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServerStatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('server_stats', function(Blueprint $table)
		{
			$table->bigInteger('shardid');
			$table->bigInteger('serverid')->unsigned()->primary();
			$table->string('name');
			$table->bigInteger('ownerid')->unsigned();
			$table->string('owner_name');
			$table->dateTime('joined_first');
			$table->dateTime('joined_last');
			$table->bigInteger('joined_count')->default(0);
			$table->bigInteger('user_count')->default(0);
			$table->boolean('vip')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('server_stats');
	}

}
