<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoleGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role_groups', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned()->default(0);
			$table->bigInteger('groupid')->default(0);
			$table->bigInteger('role_limit')->default(1);
			$table->string('name')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('role_groups');
	}

}
