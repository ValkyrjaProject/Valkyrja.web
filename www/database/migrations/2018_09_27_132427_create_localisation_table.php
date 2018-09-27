<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocalisationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('localisation', function(Blueprint $table)
		{
			$table->bigInteger('id')->unsigned()->unique('id');
			$table->string('iso');
			$table->text('about', 16777215);
			$table->text('string1', 16777215);
			$table->text('string2', 16777215);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('localisation');
	}

}
