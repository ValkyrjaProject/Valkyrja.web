<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('userid')->unsigned();
			$table->bigInteger('serverid')->unsigned();
			$table->boolean('verified')->default(0);
			$table->bigInteger('karma_count')->default(1);
			$table->bigInteger('warning_count')->default(0);
			$table->text('notes', 16777215)->nullable();
			$table->dateTime('last_thanks_time');
			$table->dateTime('banned_until');
			$table->dateTime('muted_until');
			$table->boolean('ignored');
			$table->bigInteger('count_message')->default(0);
			$table->bigInteger('count_attachments')->default(0);
			$table->bigInteger('level_relative')->default(0);
			$table->bigInteger('exp_relative');
			$table->text('memo', 65535)->nullable();
			$table->primary(['userid','serverid']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
