<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomAliasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_aliases', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned();
			$table->string('commandid');
			$table->string('alias');
			$table->primary(['serverid','alias']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('custom_aliases');
	}

}
