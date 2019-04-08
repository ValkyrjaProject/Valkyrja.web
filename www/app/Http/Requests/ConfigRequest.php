<?php

namespace App\Http\Requests;

use App\Rules\LimitedRegExOrs;
use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize()
    {
        return true; // True - middleware handles authorization
    }

    /**
     * Format relevant fields
     */
    protected function prepareForValidation()
    {
        if ($this->has('command_prefix_alt')) {
            $this['command_prefix_alt'] = (string)$this['command_prefix_alt'];
        }
        if ($this->has('roles')) {
            $roles = $this['roles'];
            for ($i = 0; $i < sizeof($roles); $i++) {
                $roles[$i]['antispam_ignored'] = ($roles[$i]['antispam_ignored'] === "true" || $roles[$i]['antispam_ignored'] === "1");
            }
            $this['roles'] = $roles;
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('custom_commands')) {
                $tempArr = [];
                foreach($this['custom_commands'] as $key => $command) {
                    $allowed = ['commandid', 'response', 'description'];
                    $tempArr[$key] = array_intersect_key($command, array_flip($allowed));
                    if (!isset($tempArr[$key]['description'])) {
                        $tempArr[$key]['description'] = '';
                    }
                }
                $this['custom_commands'] = $tempArr;
            }
            if ($this->has('roles')) {
                $tempArr = [];
                foreach($this['roles'] as $key => $command) {
                    $allowed = ['roleid', 'permission_level', 'public_id', 'antispam_ignored'];

                    if ($command['roleid'] === $this->route('serverId')) continue;
                    $tempArr[$key] = array_intersect_key($command, array_flip($allowed));
                }
                $this['roles'] = $tempArr;
            }
            if ($this->has('profile_options')) {
                $tempArr = [];
                foreach($this['profile_options'] as $key => $profile) {
                    $allowed = ['option', 'option_alt', 'label', 'property_order', 'inline'];
                    $tempArr[$key] = array_intersect_key($profile, array_flip($allowed));
                }
                $this['profile_options'] = $tempArr;
            }
            if ($this->has('role_groups')) {
                $tempArr = [];
                foreach($this['role_groups'] as $key => $profile) {
                    $allowed = ['groupid', 'role_limit', 'name'];
                    $tempArr[$key] = array_intersect_key($profile, array_flip($allowed));
                }
                $this['role_groups'] = $tempArr;
            }
            if ($this->has('quickban_reason') && is_null($this['quickban_reason'])) {
                $this['quickban_reason'] = '';
            }
            if ($this->has('welcome_message') && is_null($this['welcome_message'])) {
                $this['welcome_message'] = '';
            }
            if ($this->has('log_message_join') && is_null($this['log_message_join'])) {
                $this['log_message_join'] = '';
            }
            if ($this->has('log_message_leave') && is_null($this['log_message_leave'])) {
                $this['log_message_leave'] = '';
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ignore_bots'                       => 'required|boolean',
            'ignore_everyone'                   => 'required|boolean',
            'command_prefix'                    => 'required|string|max:255',
            'command_prefix_alt'                => 'present|string|max:255',
            'execute_on_edit'                   => 'required|boolean',
            'antispam_username'                 => 'required|boolean',
            'antispam_invites'                  => 'required|boolean',
            'antispam_invites_ban'              => 'required|boolean',
            'antispam_duplicate'                => 'required|boolean',
            'antispam_duplicate_crossserver'    => 'required|boolean',
            'antispam_duplicate_ban'            => 'required|boolean',
            'antispam_mentions_max'             => 'required|integer',
            'antispam_mentions_ban'             => 'required|boolean',
            'antispam_mute'                     => 'required|boolean',
            'antispam_mute_duration'            => 'required|integer',
            'antispam_links_extended'           => 'required|boolean',
            'antispam_links_extended_ban'       => 'required|boolean',
            'antispam_links_standard'           => 'required|boolean',
            'antispam_links_standard_ban'       => 'required|boolean',
            'antispam_links_youtube'            => 'required|boolean',
            'antispam_links_youtube_ban'        => 'required|boolean',
            'antispam_links_twitch'             => 'required|boolean',
            'antispam_links_twitch_ban'         => 'required|boolean',
            'antispam_links_hitbox'             => 'required|boolean',
            'antispam_links_hitbox_ban'         => 'required|boolean',
            'antispam_links_beam'               => 'required|boolean',
            'antispam_links_beam_ban'           => 'required|boolean',
            'antispam_links_imgur'              => 'required|boolean',
            'antispam_links_imgur_ban'          => 'required|boolean',
            'antispam_tolerance'                => 'required|integer',
            'antispam_ignore_members'           => 'required|boolean',
            'antispam_voice_switching'          => 'required|boolean',
            'operator_roleid'                   => 'required|integer',
            'quickban_duration'                 => 'required|integer',
            'quickban_reason'                   => 'string|nullable',
            'mute_roleid'                       => 'required|integer',
            'mute_ignore_channelid'             => 'required|integer',
            'karma_enabled'                     => 'required|boolean',
            'karma_limit_mentions'              => 'required|integer',
            'karma_limit_minutes'               => 'required|integer',
            'karma_limit_response'              => 'required|boolean',
            'karma_currency'                    => 'required|string|max:255',
            'karma_currency_singular'           => 'required|string|max:255',
            'karma_consume_command'             => 'required|string|max:255',
            'karma_consume_verb'                => 'required|string|max:255',
            'log_channelid'                     => 'required|integer',
            'alert_channelid'                   => 'required|integer',
            'mod_channelid'                     => 'required|integer',
            'log_bans'                          => 'required|boolean',
            'log_promotions'                    => 'required|boolean',
            'log_deletedmessages'               => 'required|boolean',
            'log_editedmessages'                => 'required|boolean',
            'activity_channelid'                => 'required|integer',
            'log_join'                          => 'required|boolean',
            'log_leave'                         => 'required|boolean',
            'log_alert_regex'                   => ['string', 'nullable', new LimitedRegExOrs(20)],
            'log_message_join'                  => 'string|nullable',
            'log_message_leave'                 => 'string|nullable',
            'log_mention_join'                  => 'required|boolean',
            'log_mention_leave'                 => 'required|boolean',
            'log_timestamp_join'                => 'required|boolean',
            'log_timestamp_leave'               => 'required|boolean',
            'log_warnings'                      => 'required|boolean',
            'welcome_pm'                        => 'required|boolean',
            'welcome_message'                   => 'string|nullable',
            'welcome_roleid'                    => 'required|integer',
            'verify'                            => 'required|boolean',
            'verify_on_welcome'                 => 'required|boolean',
            'verify_roleid'                     => 'required|integer',
            'verify_karma'                      => 'required|integer',
            'verify_message'                    => 'required|string',
            'exp_enabled'                       => 'required|boolean',
            'base_exp_to_levelup'               => 'required|integer',
            'exp_announce_levelup'              => 'required|boolean',
            'exp_per_message'                   => 'required|integer',
            'exp_per_attachment'                => 'required|integer',
            'exp_max_level'                     => 'required|integer',
            'exp_cumulative_roles'              => 'required|boolean',
            'exp_advance_users'                 => 'required|boolean',
            'exp_member_roleid'                 => 'required|integer',
            'exp_member_messages'               => 'required|integer',
            'roles'                             => 'array',
            'roles.*'                           => 'array',
            'roles.*.roleid'                    => 'required|integer|min:0',
            'roles.*.permission_level'          => 'required|integer|between:0,5',
            'roles.*.public_id'                 => 'required|integer|min:0',
            'roles.*.antispam_ignored'          => 'required|boolean',
            'levels.*.roleid'                   => 'required|integer|min:0',
            'levels.*.level'                    => 'required|integer|min:0',
            'custom_commands'                   => 'array',
            'custom_commands.*'                 => 'required|array',
            'custom_commands.*.commandid'       => 'required|alpha_num|max:127',
            'custom_commands.*.response'        => 'required|string',
            'custom_commands.*.description'     => 'string',
            'voice_channelid'                   => 'required|integer',
            'embed_voicechannel'                => 'required|boolean',
            'embed_activitychannel'             => 'required|boolean',
            'embed_logchannel'                  => 'required|boolean',
            'embed_modchannel'                  => 'required|boolean',
            'color_voicechannel'                => 'required|regex:/^#([a-f0-9]{3}){1,2}\b/i',
            'color_activitychannel'             => 'required|regex:/^#([a-f0-9]{3}){1,2}\b/i',
            'color_logchannel'                  => 'required|regex:/^#([a-f0-9]{3}){1,2}\b/i',
            'color_alertchannel'                => 'required|regex:/^#([a-f0-9]{3}){1,2}\b/i',
            'color_modchannel'                  => 'required|regex:/^#([a-f0-9]{3}){1,2}\b/i',
            'color_logmessages'                 => 'required|regex:/^#([a-f0-9]{3}){1,2}\b/i',
            'color_logwarning'                  => 'required|regex:/^#([a-f0-9]{3}){1,2}\b/i',
            'channels'                          => 'array',
            'channels.*'                        => 'array',
            'channels.*.channelid'              => 'required|integer|min:0',
            'channels.*.ignored'                => 'boolean',
            'memo_enabled'                      => 'required|boolean',
            'profile_enabled'                   => 'required|boolean',
            'profile_options'                   => 'array',
            'profile_options.*'                 => 'array',
            'profile_options.*.option'          => 'required|string|max:100',
            'profile_options.*.option_alt'      => 'required|string|max:100',
            'profile_options.*.label'           => 'required|string|max:250',
            'profile_options.*.property_order'  => 'required|integer',
            'profile_options.*.inline'          => 'required|boolean',
            'role_groups'                       => 'array',
            'role_groups.*'                     => 'array',
            'role_groups.*.groupid'             => 'required|integer',
            'role_groups.*.role_limit'          => 'required|integer',
            'role_groups.*.name'                => 'present|string|nullable|max:250',
            'reaction_roles'                    => 'array',
            'reaction_roles.*'                  => 'array',
            'reaction_roles.*.*'                => 'array',
            'reaction_roles.*.*.roleid'         => 'required|integer',
            'reaction_roles.*.*.emoji'          => 'required|string|max:250',
        ];
    }
}
