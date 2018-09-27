<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserProfileOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_profile_options', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned()->default(0);
			$table->bigInteger('userid')->unsigned()->default(0);
			$table->string('option')->nullable();
			$table->string('value', 2048)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_profile_options');
	}

}
