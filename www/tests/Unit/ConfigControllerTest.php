<?php

namespace Tests\Unit;

use App\Channels;
use App\CustomCommands;
use App\Http\Controllers\ConfigController;
use App\Roles;
use App\Http\Requests\ConfigRequest;
use App\ServerConfig;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfigControllerTest extends TestCase
{
    //use RefreshDatabase;

    public function testCustomCommands()
    {
        $form = self::getForm();
        $commands = [
            [
                'serverid' => PHP_INT_MAX,
                'commandid' => str_random(16),
                'response' => str_random(16),
                'description' => str_random(16),
            ],
            [
                'serverid' => PHP_INT_MAX,
                'commandid' => str_random(16),
                'response' => str_random(16),
                'description' => str_random(16),
            ],
            [
                'serverid' => PHP_INT_MAX,
                'commandid' => str_random(16),
                'response' => str_random(16),
                'description' => str_random(16),
            ]
        ];

        $form['custom_commands'] = &$commands;

        $response = $this->call('POST', '/config/'.$form['serverid'], $form);
        $response->assertSuccessful();
        $response->assertSee("Saved successfully");

        $this->assertEquals($commands, CustomCommands::where('serverid', PHP_INT_MAX)->get()->toArray(), "\$canonicalize = true", $delta = 0.0, $maxDepth = 10, $canonicalize = true);

        array_pop($commands);

        $response = $this->call('POST', '/config/'.$form['serverid'], $form);
        $response->assertSuccessful();
        $response->assertSee("Saved successfully");

        $this->assertEquals($commands, CustomCommands::where('serverid', PHP_INT_MAX)->get()->toArray(), "\$canonicalize = true", $delta = 0.0, $maxDepth = 10, $canonicalize = true);

/*        array_push($commands, [
            'serverid' => PHP_INT_MAX,
            'commandid' => str_random(16),
            'response' => '',
            'description' => '',
        ]);

        $response = $this->call('POST', '/config/'.$form['serverid'], $form);
        $response->assertSuccessful();
        $response->assertSee("Saved successfully");

        $this->assertEquals($commands, CustomCommands::where('serverid', PHP_INT_MAX)->get()->toArray(), "\$canonicalize = true", $delta = 0.0, $maxDepth = 10, $canonicalize = true);*/

        array_push($commands, [
            'serverid' => PHP_INT_MAX,
            'commandid' => '',
            'response' => str_random(16),
            'description' => str_random(16),
        ]);

        $response = $this->call('POST', '/config/'.$form['serverid'], $form);
        $response->assertRedirect();

        $this->assertNotEquals($commands, CustomCommands::where('serverid', PHP_INT_MAX)->get()->toArray(), "\$canonicalize = true", $delta = 0.0, $maxDepth = 10, $canonicalize = true);

    }

    public function testForm()
    {
        $form = self::getForm();

        /*$request = new ConfigRequest($form);
        $request->replace($form);
        $request->validate();
        if ($request->validated())
            dd("yes");
        else
            dd("no");

        $configController = new ConfigController();*/

        $response = $this->call('POST', '/config/'.$form['serverid'], $form);
        $response->assertSuccessful();
        $response->assertSee("Saved successfully");

        $this->assertEquals(0, count(array_diff_assoc($form, ServerConfig::where('serverid', PHP_INT_MAX)->first()->toArray())));
    }

    public static function getForm() {
        return [
                'serverid' => PHP_INT_MAX,
                'ignore_bots' => random_int(0,1),
                'ignore_everyone' => random_int(0,1),
                'command_prefix' => '#',
                'command_prefix_alt' => '',
                'execute_on_edit' => random_int(0,1),
                'antispam_priority' => random_int(0,1),
                'antispam_norole' => random_int(0,1),
                'antispam_invites' => random_int(0,1),
                'antispam_invites_ban' => random_int(0,1),
                'antispam_porn' => random_int(0,1),
                'antispam_duplicate' => random_int(0,1),
                'antispam_duplicate_crossserver' => random_int(0,1),
                'antispam_duplicate_ban' => random_int(0,1),
                'antispam_mentions_max' => random_int(0, PHP_INT_MAX),
                'antispam_mentions_ban' => random_int(0,1),
            /*TODO: Not used*/
                'antispam_mute' => random_int(0,1),
                'antispam_mute_duration' => random_int(0, PHP_INT_MAX),
            /*END: Not used*/
                'antispam_links_extended' => random_int(0,1),
                'antispam_links_extended_ban' => random_int(0,1),
                'antispam_links_standard' => random_int(0,1),
                'antispam_links_standard_ban' => random_int(0,1),
                'antispam_links_youtube' => random_int(0,1),
                'antispam_links_youtube_ban' => random_int(0,1),
                'antispam_links_twitch' => random_int(0,1),
                'antispam_links_twitch_ban' => random_int(0,1),
                'antispam_links_hitbox' => random_int(0,1),
                'antispam_links_hitbox_ban' => random_int(0,1),
                'antispam_links_beam' => random_int(0,1),
                'antispam_links_beam_ban' => random_int(0,1),
                'antispam_links_imgur' => random_int(0,1),
                'antispam_links_imgur_ban' => random_int(0,1),
                /*TODO: Not used*/
                'antispam_tolerance' => random_int(0, PHP_INT_MAX),
                /*END: Not used*/
                'antispam_ignore_members' => random_int(0,1),
                'operator_roleid' => random_int(0, PHP_INT_MAX),
                'quickban_duration' => random_int(0, PHP_INT_MAX),
                'quickban_reason' => str_random(16),
                /*TODO Below not gone through*/
                'mute_roleid' => random_int(0, PHP_INT_MAX),
                'mute_ignore_channelid' => random_int(0, PHP_INT_MAX),
                'karma_enabled' => random_int(0,1),
                'karma_limit_mentions' => random_int(0, PHP_INT_MAX),
                'karma_limit_minutes' => random_int(0, PHP_INT_MAX),
                'karma_limit_response' => random_int(0,1),
                'karma_currency' => str_random(255),
                'karma_currency_singular' => str_random(255),
                'karma_consume_command' => str_random(255),
                'karma_consume_verb' => str_random(255),
                'alert_channelid' => random_int(0, PHP_INT_MAX),
                'log_channelid' => random_int(0, PHP_INT_MAX),
                'alert_role_mention' => random_int(0, PHP_INT_MAX),
                'mod_channelid' => random_int(0, PHP_INT_MAX),
                'log_bans' => random_int(0,1),
                'log_promotions' => random_int(0,1),
                'log_deletedmessages' => random_int(0,1),
                'log_editedmessages' => random_int(0,1),
                'activity_channelid' => random_int(0, PHP_INT_MAX),
                'log_join' => random_int(0,1),
                'log_leave' => random_int(0,1),
                'log_alert_regex' => str_random(16),
                'log_message_join' => str_random(16),
                'log_message_leave' => str_random(16),
                'log_mention_join' => random_int(0,1),
                'log_mention_leave' => random_int(0,1),
                'log_timestamp_join' => random_int(0,1),
                'log_timestamp_leave' => random_int(0,1),
                'welcome_pm' => random_int(0,1),
                'welcome_message' => str_random(16),
                'welcome_roleid' => random_int(0, PHP_INT_MAX),
                'verify' => random_int(0,1),
                'verify_on_welcome' => random_int(0,1),
                'verify_roleid' => random_int(0, PHP_INT_MAX),
                'verify_karma' => random_int(0, PHP_INT_MAX),
                'verify_message' => str_random(16),
                'exp_enabled' => random_int(0,1),
                'base_exp_to_levelup' => random_int(0, PHP_INT_MAX),
                'exp_announce_levelup' => random_int(0,1),
                'exp_per_message' => random_int(0, PHP_INT_MAX),
                'exp_per_attachment' => random_int(0, PHP_INT_MAX),
                'exp_cumulative_roles' => random_int(0,1),
            ];
    }
}
