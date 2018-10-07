<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServerConfigTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('server_config', function(Blueprint $table)
		{
			$table->bigInteger('serverid')->unsigned()->unique('serverid');
			$table->string('name');
			$table->string('invite_url');
			$table->bigInteger('localisation_id')->unsigned()->default(0);
			$table->bigInteger('timezone_utc_relative')->default(0);
			$table->boolean('use_database')->default(1);
			$table->boolean('ignore_bots')->default(1);
			$table->boolean('ignore_everyone')->default(1);
			$table->string('command_prefix')->default('!');
			$table->string('command_prefix_alt');
			$table->boolean('execute_on_edit')->default(1);
			$table->boolean('antispam_priority')->default(0);
			$table->boolean('antispam_invites')->default(0);
			$table->boolean('antispam_invites_ban')->default(0);
			$table->boolean('antispam_duplicate')->default(0);
			$table->boolean('antispam_duplicate_crossserver')->default(0);
			$table->boolean('antispam_duplicate_ban')->default(0);
			$table->bigInteger('antispam_mentions_max')->default(0);
			$table->boolean('antispam_mentions_ban')->default(0);
			$table->boolean('antispam_mute')->default(0);
			$table->bigInteger('antispam_mute_duration')->default(5);
			$table->boolean('antispam_links_extended')->default(0);
			$table->boolean('antispam_links_extended_ban')->default(0);
			$table->boolean('antispam_links_standard')->default(0);
			$table->boolean('antispam_links_standard_ban')->default(0);
			$table->boolean('antispam_links_youtube')->default(0);
			$table->boolean('antispam_links_youtube_ban')->default(0);
			$table->boolean('antispam_links_twitch')->default(0);
			$table->boolean('antispam_links_twitch_ban')->default(0);
			$table->boolean('antispam_links_hitbox')->default(0);
			$table->boolean('antispam_links_hitbox_ban')->default(0);
			$table->boolean('antispam_links_beam')->default(0);
			$table->boolean('antispam_links_beam_ban')->default(0);
			$table->boolean('antispam_links_imgur')->default(0);
			$table->boolean('antispam_links_imgur_ban')->default(0);
			$table->bigInteger('antispam_tolerance')->default(4);
			$table->boolean('antispam_ignore_members')->default(0);
			$table->bigInteger('operator_roleid')->unsigned()->default(0);
			$table->bigInteger('quickban_duration')->default(0);
			$table->text('quickban_reason', 16777215)->nullable();
			$table->bigInteger('mute_roleid')->unsigned()->default(0);
			$table->bigInteger('mute_ignore_channelid')->unsigned()->default(0);
			$table->boolean('karma_enabled')->default(0);
			$table->bigInteger('karma_limit_mentions')->default(5);
			$table->bigInteger('karma_limit_minutes')->default(30);
			$table->boolean('karma_limit_response')->default(1);
			$table->string('karma_currency')->default('cookies');
			$table->string('karma_currency_singular')->default('cookies');
			$table->string('karma_consume_command')->default('nom');
			$table->string('karma_consume_verb')->default('nommed');
			$table->bigInteger('log_channelid')->unsigned()->default(0);
			$table->bigInteger('mod_channelid')->unsigned()->default(0);
			$table->boolean('log_bans')->default(0);
			$table->boolean('log_promotions')->default(0);
			$table->boolean('log_deletedmessages')->default(0);
			$table->boolean('log_editedmessages')->default(0);
			$table->bigInteger('activity_channelid')->unsigned()->default(0);
			$table->boolean('log_join')->default(0);
			$table->boolean('log_leave')->default(0);
			$table->text('log_message_join', 16777215)->nullable();
			$table->text('log_message_leave', 16777215)->nullable();
			$table->boolean('log_mention_join')->default(0);
			$table->boolean('log_mention_leave')->default(0);
			$table->boolean('log_timestamp_join')->default(0);
			$table->boolean('log_timestamp_leave')->default(0);
			$table->boolean('welcome_pm')->default(0);
			$table->text('welcome_message', 16777215)->nullable();
			$table->bigInteger('welcome_roleid')->unsigned()->default(0);
			$table->boolean('verify')->default(0);
			$table->boolean('verify_on_welcome')->default(0);
			$table->bigInteger('verify_roleid')->unsigned()->default(0);
			$table->bigInteger('verify_karma')->default(3);
			$table->text('verify_message', 16777215)->nullable();
			$table->boolean('exp_enabled')->default(0);
			$table->bigInteger('base_exp_to_levelup');
			$table->boolean('exp_announce_levelup');
			$table->bigInteger('exp_per_message');
			$table->bigInteger('exp_per_attachment');
			$table->boolean('exp_cumulative_roles')->default(0);
			$table->bigInteger('voice_channelid')->unsigned()->default(0);
			$table->boolean('antispam_voice_switching')->default(0);
			$table->integer('color_logmessages')->unsigned()->default(16776960);
			$table->integer('color_modchannel')->unsigned()->default(16711680);
			$table->integer('color_logchannel')->unsigned()->default(255);
			$table->integer('color_activitychannel')->unsigned()->default(65535);
			$table->integer('color_voicechannel')->unsigned()->default(65280);
			$table->boolean('embed_modchannel')->default(0);
			$table->boolean('embed_logchannel')->default(0);
			$table->boolean('embed_activitychannel')->default(0);
			$table->boolean('embed_voicechannel')->default(0);
			$table->bigInteger('karma_per_level')->unsigned()->default(3);
			$table->bigInteger('exp_max_level')->unsigned()->default(0);
			$table->boolean('exp_advance_users')->default(0);
			$table->boolean('profile_enabled')->default(0);
			$table->boolean('memo_enabled')->default(0);
			$table->boolean('log_warnings')->default(0);
			$table->integer('color_logwarning')->unsigned()->default(16489984);
            $table->bigInteger('exp_member_messages')->default(0);
            $table->bigInteger('exp_member_roleid')->unsigned()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('server_config');
	}

}
