<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned();
			$table->bigInteger('roleid')->unsigned()->primary();
			$table->boolean('permission_level')->default(0);
			$table->bigInteger('public_id')->default(0);
			$table->boolean('logging_ignored')->default(0);
			$table->boolean('antispam_ignored')->default(0);
			$table->bigInteger('level')->default(0);
			$table->dateTime('delete_at_time')->default('1970-01-01 01:00:00');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
	}

}
