<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfileOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profile_options', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned()->default(0);
			$table->bigInteger('property_order')->default(0);
			$table->string('option')->nullable();
			$table->string('option_alt')->nullable();
			$table->string('label', 2048)->nullable();
			$table->boolean('inline')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('profile_options');
	}

}
