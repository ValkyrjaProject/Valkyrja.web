<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGlobalConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('global_config', function(Blueprint $table)
		{
			$table->string('configuration_name')->unique('configuration_name');
			$table->string('discord_token');
			$table->bigInteger('userid')->unsigned()->default(278834060053446666);
			$table->bigInteger('admin_userid')->unsigned()->default(89805412676681728);
			$table->boolean('enforce_requirements')->default(0);
			$table->boolean('verification_enabled')->default(0);
			$table->boolean('timers_enabled')->default(0);
			$table->boolean('polls_enabled')->default(0);
			$table->boolean('events_enabled')->default(0);
			$table->boolean('giveaways_enabled')->default(0);
			$table->boolean('livestream_enabled')->default(0);
			$table->bigInteger('total_shards')->default(1);
			$table->bigInteger('initial_update_delay')->default(1);
			$table->string('command_prefix')->default('!');
			$table->bigInteger('main_serverid')->unsigned()->default(155821059960995840);
			$table->bigInteger('main_channelid')->unsigned()->default(170139120318808065);
			$table->boolean('vip_skip_queue')->default(0);
			$table->bigInteger('vip_members_max')->default(0);
			$table->bigInteger('vip_trial_hours')->default(36);
			$table->bigInteger('vip_trial_joins')->default(5);
			$table->bigInteger('antispam_clear_interval')->default(10);
			$table->bigInteger('antispam_safety_limit')->default(30);
			$table->bigInteger('antispam_fastmessages_per_update')->default(5);
			$table->bigInteger('antispam_update_interval')->default(6);
			$table->bigInteger('antispam_message_cache_size')->default(6);
			$table->bigInteger('antispam_allowed_duplicates')->default(2);
			$table->float('target_fps', 10, 0)->default(0.05);
			$table->bigInteger('operations_max')->default(2);
			$table->bigInteger('operations_extra')->default(1);
			$table->bigInteger('maintenance_memory_threshold')->default(3000);
			$table->bigInteger('maintenance_thread_threshold')->default(44);
			$table->bigInteger('maintenance_operations_threshold')->default(300);
			$table->bigInteger('maintenance_disconnect_threshold')->default(20);
			$table->boolean('log_debug')->default(0);
			$table->boolean('log_exceptions')->default(1);
			$table->boolean('log_commands')->default(1);
			$table->boolean('log_responses')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('global_config');
	}

}
