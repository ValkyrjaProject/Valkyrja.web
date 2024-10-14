@extends('layouts.master')

@section('title', 'Config')

@section('header')
    <script type="application/javascript">
        window.__INITIAL_STATE__ = "{!! addslashes(json_encode([
			'channels' => array_values($guild['channels']->all()),
			'categories' => array_values($guild['categories']->all()),
			'roles' => array_values($guild['roles']->all()),
			'custom_commands' => old('custom_commands', (isset($errors) && count($errors) > 0) ? [] : $customCommands->all()),
			'rolesData' => old('roles', (isset($errors) && count($errors) > 0) ? [] : $roles->all()),
			'channelsData' => old('channels', (isset($errors) && count($errors) > 0) ? [] : $channels->all()),
			'profile_options' => old('profile_options', (isset($errors) && count($errors) > 0) ? [] : $profile_options->all()),
			'role_groups' => old('role_groups', (isset($errors) && count($errors) > 0) ? [] : $role_groups->all()),
			'reaction_roles' => old('reaction_roles', (isset($errors) && count($errors) > 0) ? [] : $reaction_roles->all()),
			'localisation' => old('localisation', (isset($errors) && count($errors) > 0) ? null : $localisation ? $localisation : null)
        ])) !!}";
        window.__LOCALISATION_DEFAULTS__ = '{!! addslashes(json_encode($localisation_defaults)) !!}';
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="col-xs-12">
            <form action="{{ url('config/'.$serverId) }}" method="post" @submit.prevent>
                <h1 class="col-md-6">
                    <v-loading message='Configure Valkyrja'>
                    <span slot='spinner' class="align-bottom">
                        <v-loading-spinner width='1em' height='1em'></v-loading-spinner>
                    </span>
                        <span>Configure Valkyrja</span>
                    </v-loading>
                </h1>
                <span class="col-md-6">
                  <table><tr>
                    <td style="vertical-align:middle; width:auto">
                      <button class="btn btn-primary" type="button" :disabled="anyLoading" @click="onSubmit">Save</button>
                    </td>
                    <td style="vertical-align:middle; width:20px">
                        <input type="hidden" name="tos" :value="tos ? 1 : 0">
                        <tos-field :init-value="{{ old('tos', $serverConfig["tos"]) }}"></tos-field>
                    </td>
                    <td style="vertical-align:middle; width:auto; font-size:10pt">
                        By using the Valkyrja bot you agree to storing End User data (in compliance with Discord ToS) necessary for the functionality as configured on this website.
                    </td>
                  </tr></table>
                </span>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#configBasic" aria-expanded="true" aria-controls="configBasic">
                    Basic configuration
                </button>
                <div class="form-inline form-group collapse in" id="configBasic"><br/>
                    <p>
                        <b>Permissions</b>
                        <br/>
                        Valkyrja expects server and channel permissions to be correct and some functions may not work
                        if you do not pay enough attention to this topic.
                        <br/>
                        First permissions of the bot - you have to not only give it the permissions but also <a
                                href="http://i.imgur.com/T8MPvME.png" target="_blank">to move it up in the <u>roles
                                hierarchy</u></a>. The bot can only assign roles to, and kick or ban users that are
                        below his own role.
                        <br/>
                        Second common mistake is wallpapering (to some degree) channel permissions. This may prevent the
                        bot from talking - executing commands, this may also block it from correctly handling channel or
                        user mute, etc. Read <a
                                href="http://rhea-ayase.eu/articles/2016-12/Discord-Guide-Server-setup-and-permissions"
                                target="_blank">this guide about permissions</a>.
                    </p>
                    <p>
                        <b>Command Prefix</b> - required option, do not leave this empty!<br/>
                        <text-field init-id="command_prefix" init-name="command_prefix"
                                    init-value="{{ old('command_prefix', $serverConfig["command_prefix"]) }}"></text-field>
                    </p>
                    <p>
                        <b>Alternative Command Prefix</b> - will be used as well as the above, you can leave this one
                        empty.<br/>
                        @include("config.types.text", ['key' => "command_prefix_alt", 'data' => old('command_prefix_alt', $serverConfig["command_prefix_alt"])])
                    </p>
                    <p>
                        @include("config.types.bool", ['key' => "execute_on_edit", 'data' => old('execute_on_edit', $serverConfig["execute_on_edit"])])
                        <b>Execute commands in edited messages</b>
                        <br/>
                    </p>
                    <p>
                        @include("config.types.bool", ['key' => "nicknames", 'data' => old('nicknames', $serverConfig["nicknames"])])
                        <b>Record Nickname history.</b>
                        <br/>
                    </p>
                    <p>
                        @include("config.types.bool", ['key' => "ignore_bots", 'data' => old('ignore_bots', $serverConfig["ignore_bots"])])
                        <b>Do not execute any commands issued by bots.</b>
                        <br/>
                    </p>
                    <p>
                        @include("config.types.bool", ['key' => "ignore_everyone", 'data' => old('ignore_everyone', $serverConfig["ignore_everyone"])])
                        <b>Ignore <code>@everyone</code> mentions.</b> This is to prevent accidental
                        <code>@everyone</code> mentions, it is strongly recommended to keep this enabled.
                        <br/>
                    </p>
                    <p>
                        Notification channel - permission issues and other errors will go here, as well as config reload notifications.
                        <br/>
                        <type-selector init-id-type="notification_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('notification_channelid', $serverConfig["notification_channelid"]))) }}'
                                       :values='channels'></type-selector>
                    </p>
                </div>
                <button class="btn btn-fading btn-full-width"  type="button" data-toggle="collapse"
                        data-target="{{ $isPremium ? "#configAntispam" : "#subscribeConfigAntispam"}}" aria-expanded="false" aria-controls="{{ $isPremium ? "configAntispam" : "subscribeConfigAntispam"}}">
                    Antispam
                </button>
                <div class="form-inline form-group collapse" id="subscribeConfigAntispam">
                    <a class="d-block text-center" href="https://www.github.com/sponsors/RheaAyase" target="_blank">Subscribe to utilize Antispam features.</a>
                </div>
                <div class="form-inline form-group collapse {{ !$isPremium ? "hide-section" : ""}}" id="configAntispam"><br/>
                    <h2>Info</h2>
                    <div class="features-indent">
                      <p>
                          Valkyrja will act as configured below, if it takes any action, it will PM the naughty user
                          letting them know about it. If you configure it to also ban for excessive spam, it will let the
                          user know one message before banning them. Removed messages and banned users will be logged as
                          configured in the <code>Moderation Log</code> section.
                          <br/>
                          <i>Antispam will not even try to do anything if the bot does not have
                              <code>ManageMessages</code> & <code>Ban</code> permissions.</i>
                      </p>
                    </div>
                    <h2>Ignore lists</h2>
                    <div class="features-indent">
                      <p>
                          <b>Ignored roles and channels</b>
                          <br/>
                          Antispam will not take any action against Admins or Moderators.
                          <br/>
                          You can configure specific channels to be ignored by logging and antispam in the logging section below.
                          <br/>
                          Remember that you can <code>@{{ command_prefix }}permit @people</code> to allow anyone mentioned to post a single link or anything else in this section, for three minutes.
                      </p>
                      <p>
                          <b>Ignored roles</b> - messages deleted or edited by people with these roles will not be logged and antispam won't take action against them.
                          <br />
                          <role-antispam-selector></role-antispam-selector>
                      </p>
                      <p>
                          <b>Members ignore Antispam</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_ignore_members", 'data' => old('antispam_ignore_members', $serverConfig["antispam_ignore_members"])])
                          Should members of roles configured on this page as <code>Member Roles</code> ignore this
                          antispam?
                          <br/>
                          <i>Hint - an awesome combo of different features together with this checkbox: You can configure
                              antispam to be really harsh, use <code>Verification</code> (configured below) and have the
                              Verified role also be a <code>Member</code> (configured in Moderation section)</i>
                      </p>
                    </div>
                    <h2>Punishment</h2>
                    <div class="features-indent">
                      <p>
                          <b>Automated Mute</b>
                          <br/>
                          How many of the below configured <code>Infractions</code> do we tolerate before muting the user?
                          <i>Requires <code>Muted Role</code> to be configured in the <code>Moderation</code> section.</i>
                          <br/>
                          @include("config.types.int", ['key' => "antispam_tolerance", 'data' => old('antispam_tolerance', $serverConfig["antispam_tolerance"])])
                          (Use <code>0</code> (zero) to disable.)
                          <br/>
                          Duration of the mute:
                          <br/>
                          @include("config.types.int", ['key' => "antispam_mute_duration", 'data' => old('antispam_mute_duration', $serverConfig["antispam_mute_duration"])])
                          (minutes)
                          <br/><br/>
                          <b>Automated ban</b>
                          <br/>
                          How many of the below configured <code>Infractions</code> do we tolerate before banning the user?
                          <br/>
                          <text-field init-id="antispam_tolerance_ban" init-name="antispam_tolerance_ban"
                                      init-value="{{ old('antispam_tolerance_ban', $serverConfig["antispam_tolerance_ban"]) }}"></text-field>
                          (Use <code>0</code> (zero) to disable.)
                          <br/><br/>
                          <b>Recommended configuration</b>
                          <br/>
                          For the best results we recommend these to be either <code>Mute=1</code> & <code>Ban=4</code>
                          or <code>Mute=2</code> & <code>Ban=6</code> which translate into "mute twice, then ban." (<code>b=(m+1)*2</code>)
                      </p>
                    </div>
                    <h2>New user</h2>
                    <div class="features-indent">
                      <p>
                          <b>Ban username-spammers as they join</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_username", 'data' => old('antispam_username', $serverConfig["antispam_username"])])
                          This will immediately ban all the users who have any Discord invites, twitch, youtube or other kinds of naughty links in their username. This will also ban if multiple people join with identical username within short time period.
                      </p>
                      <p>
                          <b>Limit join-rate (aka Anti-Raid)</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_joinrate_enabled", 'data' => old('antispam_joinrate_enabled', $serverConfig["antispam_joinrate_enabled"])])
                          Limit join-rate by kicking (or 
                          @include("config.types.bool", ['key' => "antispam_joinrate_ban", 'data' => old('antispam_joinrate_ban', $serverConfig["antispam_joinrate_ban"])])
                          ban for 1h?) people if more than:
                          <br/>
                          <text-field init-id="antispam_joinrate_count" init-name="antispam_joinrate_count"
                                      init-value="{{ old('antispam_joinrate_count', $serverConfig["antispam_joinrate_count"]) }}"></text-field>
                          users join in
                          <text-field init-id="antispam_joinrate_seconds" init-name="antispam_joinrate_seconds"
                                      init-value="{{ old('antispam_joinrate_seconds', $serverConfig["antispam_joinrate_seconds"]) }}"></text-field>
                          seconds (don't go over 300 seconds, that's too much!)
                          <br/>
                          Valkyrja will PM the kicked/banned people informing them about what's happening and that they can re-join later - in case they're real humans.
                      </p>
                      <p>
                          <b>More...</b>
                          <br/>
                          For more verification options and options to kick people who fail it see the Verification section below.
                      </p>
                    </div>
                    <h2>Infractions</h2>
                    <div class="features-indent">
                      <p>
                          <b>discord invites</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_invites", 'data' => old('antispam_invites', $serverConfig["antispam_invites"])])
                          remove messages that contain discord invites?
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_invites_ban", 'data' => old('antispam_invites_ban', $serverConfig["antispam_invites_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> invites have been removed?
                          <br/>This will also ban all those cute bots with invites in their name as soon as they join.
                      </p>
                      <p>
                          <b>Duplicate messages</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_duplicate", 'data' => old('antispam_duplicate', $serverConfig["antispam_duplicate"])])
                          Remove duplicate messages? Also known as <i>literally spam</i>.
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_duplicate_multiuser", 'data' => old('antispam_duplicate_multiuser', $serverConfig["antispam_duplicate_multiuser"])])
                          We can also remove these between people. When spambots join to raid, it's often in large numbers and instead spamming less frequently. This will deal with this case.
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_duplicate_crossserver", 'data' => old('antispam_duplicate_crossserver', $serverConfig["antispam_duplicate_crossserver"])])
                          We can also remove these cross-server. Imagine that there is someone going through many servers and posting some advertisement everywhere, but only a single message per-server so it doesn't count as standard spam. Valkyrja would notice these messages as being duplicates between servers.
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_duplicate_ban", 'data' => old('antispam_duplicate_ban', $serverConfig["antispam_duplicate_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> messages have been removed?
                      </p>
                      <p>
                          <b>Mass-mentions</b>
                          <br/>
                          Remove messages that mention more than <code>n</code> people? Set to <code>0</code> (zero) to
                          disable, otherwise set the <code>n</code> amount.
                          <br/>
                          @include("config.types.int", ['key' => "antispam_mentions_max", 'data' => old('antispam_mentions_max', $serverConfig["antispam_mentions_max"])])
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_mentions_ban", 'data' => old('antispam_mentions_ban', $serverConfig["antispam_mentions_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> messages have been removed?
                      </p>
                      <p>
                          <b>Mute fast-message spam</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_mute", 'data' => old('antispam_mute', $serverConfig["antispam_mute"])])
                          Temporarily mute people if they send too many messages too fast? This is done by assigning them
                          <code>Muted Role</code>, and if they continue spamming after they get muted twice, they get
                          banned, because that's an obvious spambot. Both, the mute and the ban are logged as configured
                          in the <code>Logging</code> section.
                          <br/>
                          Requires <code>Muted Role</code> to be configured in the <code>Moderation</code> section.
                      </p>
                      <p>
                          <b>Known Porn links</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_porn", 'data' => old('antispam_porn', $serverConfig["antispam_porn"])])
                          Remove known porn links? (This is manually updated, if you see something that's not covered, let us know please!)
                      </p>
                      <p>
                          <b>YouTube links</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_youtube", 'data' => old('antispam_links_youtube', $serverConfig["antispam_links_youtube"])])
                          Remove YouTube links?
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_youtube_ban", 'data' => old('antispam_links_youtube_ban', $serverConfig["antispam_links_youtube_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> links have been removed?
                      </p>
                      <p>
                          <b>Twitch links</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_twitch", 'data' => old('antispam_links_twitch', $serverConfig["antispam_links_twitch"])])
                          Remove Twitch links?
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_twitch_ban", 'data' => old('antispam_links_twitch_ban', $serverConfig["antispam_links_twitch_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> links have been removed?
                      </p>
                      <p>
                          <b>Hitbox/Smashcast links</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_hitbox", 'data' => old('antispam_links_hitbox', $serverConfig["antispam_links_hitbox"])])
                          Remove Hitbox and Smashcast links?
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_hitbox_ban", 'data' => old('antispam_links_hitbox_ban', $serverConfig["antispam_links_hitbox_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> links have been removed?
                      </p>
                      <p>
                          <b>Beam/Mixer links</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_beam", 'data' => old('antispam_links_beam', $serverConfig["antispam_links_beam"])])
                          Remove Beam and Mixer links?
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_beam_ban", 'data' => old('antispam_links_beam_ban', $serverConfig["antispam_links_beam_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> links have been removed?
                      </p>
                      <p>
                          <b>Imgur-like links</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_imgur", 'data' => old('antispam_links_imgur', $serverConfig["antispam_links_imgur"])])
                          Remove imgur, gfycat, giphy or tinypic links?
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_imgur_ban", 'data' => old('antispam_links_imgur_ban', $serverConfig["antispam_links_imgur_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> links have been removed?
                      </p>
                      <p>
                          <b>All the Chan links</b> (4chan, 8kun, etc..)
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_chan", 'data' => old('antispam_links_chan', $serverConfig["antispam_links_chan"])])
                          Remove all the Chan links?
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_chan_ban", 'data' => old('antispam_links_chan_ban', $serverConfig["antispam_links_chan_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> links have been removed?
                      </p>
                      <p>
                          <b>All standard links</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_standard", 'data' => old('antispam_links_standard', $serverConfig["antispam_links_standard"])])
                          Remove all standard links? This is a list of more-less standard <code>TLD</code>s to be removed,
                          for example <code>.com</code>, <code>.net</code>, and many others... <i>(except the options
                              above (youtube, imgur,..) - enable those if you want them removed as well.)</i>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_standard_ban", 'data' => old('antispam_links_standard_ban', $serverConfig["antispam_links_standard_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> links have been removed?
                      </p>
                      <p>
                          <b>Extended links</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_extended", 'data' => old('antispam_links_extended', $serverConfig["antispam_links_extended"])])
                          Remove Extended links? Extended links are basically <code>anything.anything</code>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_links_extended_ban", 'data' => old('antispam_links_extended_ban', $serverConfig["antispam_links_extended_ban"])])
                          Ban people after <code>@{{ antispam_tolerance_ban }}</code> links have been removed?
                      </p>
                      <p>
                          <b>Voice Channel switching</b>
                          <br/>
                          @include("config.types.bool", ['key' => "antispam_voice_switching", 'data' => old('antispam_voice_switching', $serverConfig["antispam_voice_switching"])])
                          Warn and ban (for one hour) people who spam-switch voice channels.
                      </p>
                    </div>
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#configModeration" aria-expanded="false" aria-controls="configModeration">
                    Moderation
                </button>
                <div class="form-inline form-group collapse" id="configModeration">
                    <p>
                        <b>Roles</b>
                        <br/>
                        Assign roles different permission levels - refer to the documentation to see what each permission level can do. (You can also customize that per-command using the <code>@{{ command_prefix }}permissions</code> command.)
                        <br/>
                        <role-permission>
                            <template slot-scope="props">
                                    <span v-for="role in props.addedTypesLevel">
                                        <input type="hidden"
                                                :name="'roles['+props.addedTypesLevel.indexOf(role)+'][roleid]'"
                                                :value="role.roleid">
                                        <input type="hidden"
                                                :name="'roles['+props.addedTypesLevel.indexOf(role)+'][permission_level]'"
                                                :value="role.permission_level">
                                        <input type="hidden"
                                                :name="'roles['+props.addedTypesLevel.indexOf(role)+'][public_id]'"
                                                :value="role.public_id">
                                        <input type="hidden"
                                                :name="'roles['+props.addedTypesLevel.indexOf(role)+'][antispam_ignored]'"
                                                :value="role.antispam_ignored">
                                    </span>
                            </template>
                        </role-permission>
                    </p>
                    <p>
                        <b>!op</b>
                        <br/>
                        This feature will act like Operators known from IRC. If configured, it will disable the use of
                        ban/kick/mute commands unless <i>you</i> are <code>@{{ command_prefix }}op</code>-ed (you can
                        still use quickban, if configured, because it's quick!) This helps making it clear to the user,
                        that <i>you</i> are now a acting as a moderator and you are not just joking around. Set the
                        Operator role below to enable it.
                        <br/><br/>
                        <b>Operator</b> role. Hint: You can configure this role to have nice vibrant colour, to send a
                        clear message to everyone that a moderator is there.
                        <br/>
                        <type-selector init-id-type="operator_roleid" label="name"
                                       :default-value='{{ json_encode($guild['roles']->get(old('operator_roleid', $serverConfig["operator_roleid"]))) }}'
                                       :values='roles'></type-selector>
                        <br/>
                        @include("config.types.bool", ['key' => "operator_enforce", 'data' => old('operator_enforce', $serverConfig["operator_enforce"])])
                        Require OP for moderation actions.
                    </p>
                    <p>
                        <b>Ban Default</b>
                        <br/>
                        Default ban duration, leave empty to disable.
                        <br/>
                        @include("config.types.text", ['key' => "ban_duration", 'data' => old('ban_duration', $serverConfig["ban_duration"])]) (<code>1d3h</code> format)
                    </p>
                    <p>
                        <b>Ban Limit</b>
                        <br/>
                        Limit how many members can you kick or ban using a single command. Set <code>0</code> (zero) for unlimited. Bypass using <code>@{{ command_prefix }}banMany</code> or <code>@{{ command_prefix }}kickMany</code>
                        <br/>
                        @include("config.types.int", ['key' => "ban_limit", 'data' => old('ban_limit', $serverConfig["ban_limit"])])
                    </p>
                    <p>
                        <b>Quickban</b>
                        <br/>
                        Should you wish to use the <code>@{{ command_prefix }}quickban</code> you have to configure the reason why are you banning the user. This will be PMed them just like with standard <code>@{{ command_prefix }}ban</code>. We recommend something like <code>Ignoring the rules / spamming inappropriate content.</code> (The command will be disabled if you leave this field empty.)
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "quickban_reason", 'data' => old('quickban_reason', $serverConfig["quickban_reason"])])
                        <br/><br/>
                        And for how long do you want to ban them using this command? Set <code>0</code> (zero) for permanent ban.
                        <br/>
                        @include("config.types.int", ['key' => "quickban_duration", 'data' => old('quickban_duration', $serverConfig["quickban_duration"])]) (hours)
                    </p>
                    <p>
                        <code>Muted Role</code> - Role that will be used for the purpose of muting people, this role
                        will be configured by Valkyrja to prevent people from talking in all your channels. Should you wish to exclude some channels from this configuration, add the role to the channel yourself and the bot won't touch its permissions.
                        <br/>
                        <type-selector init-id-type="mute_roleid" label="name"
                                       :default-value='{{ json_encode($guild['roles']->get(old('mute_roleid',$serverConfig["mute_roleid"]))) }}'
                                       :values='roles'></type-selector>
                        <br/><br/>
                        The above role will not be configured in the following channel, allowing you to talk to muted
                        people in it.
                        <br/>
                        <type-selector init-id-type="mute_ignore_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('mute_ignore_channelid', $serverConfig["mute_ignore_channelid"]))) }}'
                                       :values='channels'></type-selector>
                        <br/>
                        Example usage of this <i>chill-zone</i> channel: <a href="/img/mute.gif" target="_blank">gif</a>
                        which can be configured with <a href="/img/mute-permissions.gif" target="_blank">these
                            permissions</a>.
                        <br/><br/>
                        Include this in a PM to the muted user: (useful if you want to tell them to use a modmail bot instead of the above muted channel)
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "mute_message", 'data' => old('mute_message', $serverConfig["mute_message"])])
                    </p>
                    <p>
                        <b>Slow mode</b>
                        <br/>
                        Default duration for the <code>@{{ command_prefix }}slow</code> command:
                        <br/>
                        @include("config.types.int", ['key' => "slowmode_default", 'data' => old('slowmode_default', $serverConfig["slowmode_default"])])
                        (one message every <code>n</code>seconds)
                    </p>
                    <p>
                        <b><a href="http://rhea-ayase.eu/articles/2017-04/Moderation-guidelines" target="_blank">Moderation
                                Guidelines</a></b>
                        <br/>
                        Moderation guidelines for inclusive community. <i>(Written by Rhea.)</i>
                        <br/>
                        <b><a href="http://rhea-ayase.eu/articles/2016-11/On-the-topic-of-moderation" target="_blank">On
                                the topic of Moderation</a></b>
                        <br/>
                        Another article about moderating a community, full of Discord/Valkyrja examples. <i>(Written by
                            Rhea.)</i>
                    </p>
                </div>

                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#roleAssignment" aria-expanded="false" aria-controls="roleAssignment">
                    Role Assignment
                </button>
                <div class="form-inline form-group collapse" id="roleAssignment">
                    <p>
                        <b>Public Roles</b>
                        <br/>
                        Public Roles can be taken by anyone using the <code>@{{ command_prefix }}join</code> command. Please see the documentation for detailed command reference.
                        <br/>
                        These default to <code>No group</code> where any user can <code>@{{ command_prefix }}join</code> any of these roles. Any other public role group will be exclusive, and the user can have only one role out of a group at the time. You can have multiple groups.
                        <role-selector>
                            <template slot-scope="props">
                                <span v-for="role in props.addedTypesLevel">
                                    <input type="hidden"
                                            :name="'roles['+props.addedTypesLevel.indexOf(role)+'][roleid]'"
                                            :value="role.roleid">
                                    <input type="hidden"
                                            :name="'roles['+props.addedTypesLevel.indexOf(role)+'][permission_level]'"
                                            :value="role.permission_level">
                                    <input type="hidden"
                                            :name="'roles['+props.addedTypesLevel.indexOf(role)+'][public_id]'"
                                            :value="role.public_id">
                                    <input type="hidden"
                                            :name="'roles['+props.addedTypesLevel.indexOf(role)+'][antispam_ignored]'"
                                            :value="role.antispam_ignored">
                                </span>
                                <span v-for="group in props.roleGroups">
                                    <input type="hidden"
                                            :name="'role_groups['+props.roleGroups.indexOf(group)+'][groupid]'"
                                            :value="group.id">
                                    <input type="hidden"
                                            :name="'role_groups['+props.roleGroups.indexOf(group)+'][role_limit]'"
                                            :value="group.role_limit">
                                    <input type="hidden"
                                            :name="'role_groups['+props.roleGroups.indexOf(group)+'][name]'"
                                            :value="group.name">
                                </span>
                            </template>
                        </role-selector>
                    </p>
                    <p>
                        <b>Reaction Assigned Roles</b><br/>
                        <i>(Hint: Public Role Groups configured above will also affect Reaction Assigned Roles.)</i>
                        <reaction-roles form-name="reaction_roles"></reaction-roles>
                    </p>
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#configLogging" aria-expanded="false" aria-controls="configLogging">
                    Logging
                </button>
                <div class="form-inline form-group collapse" id="configLogging"><br/>
                    <p>
                        <b>Moderation Log Channel</b> - In which channel would you like to log the below configured events?
                        <br/>
                        <type-selector init-id-type="mod_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('mod_channelid', $serverConfig["mod_channelid"]))) }}'
                                       :values='channels'></type-selector>
                        <br/>
                        @include("config.types.bool", ['key' => "embed_modchannel", 'data' => old('embed_modchannel', $serverConfig["embed_modchannel"])])
                        Use Embed with below configured colours
                        <br/><br/>
                        @include("config.types.bool", ['key' => "log_bans", 'data' => old('log_bans', $serverConfig["log_bans"])])
                        Log muted, kicked and banned users
                        <color-picker input-name="color_modchannel"
                                      hex-value="{{old('color_modchannel', $serverConfig["color_modchannel"])}}"></color-picker>
                        <br/><br/>
                        @include("config.types.bool", ['key' => "log_warnings", 'data' => old('log_warnings', $serverConfig["log_warnings"])])
                        Log warnings (<code>@{{ command_prefix }}addWarning</code> and <code>@{{ command_prefix }}issueWarning</code> commands)
                        <br/>
                        <color-picker input-name="color_logwarning"
                                      hex-value="{{old('color_logwarning', $serverConfig["color_logwarning"])}}"></color-picker>
                        <br/><br/>
                        <b>Alert Channel</b> - Log all the message that match below configured regular expression. (Leave empty to disable.)
                        <br/>
                        <type-selector init-id-type="alert_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('alert_channelid', $serverConfig["alert_channelid"]))) }}'
                                       :values='channels'></type-selector>
                        <br/>
                        <color-picker input-name="color_alertchannel"
                                      hex-value="{{old('color_alertchannel', $serverConfig["color_alertchannel"])}}"></color-picker>
                        <br/>
                        Set a role you'd like mentioned with every alert (optional)
                        <br/>
                        <type-selector init-id-type="alert_role_mention" label="name"
                                       :default-value='{{ json_encode($guild['roles']->get(old('alert_role_mention',$serverConfig["alert_role_mention"]))) }}'
                                       :values='roles'></type-selector>
                        <br/>
                        Use a <a href="https://regex101.com">regular expression</a> to match messages, for example <code>gh?a+y|fag|nigger</code>. (Up to 30 RegEx ORs <code>|</code>)
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "log_alert_regex", 'data' => old('log_alert_regex', $serverConfig["log_alert_regex"])])
                        <br/>
                        Matching messages of this <a href="https://regex101.com">regular expression</a> will be deleted. (Up to 20 RegEx ORs <code>|</code>)
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "delete_alert_regex", 'data' => old('delete_alert_regex', $serverConfig["delete_alert_regex"])])
                        <br/><br/>
                        <b>Log Channel</b> - In which channel would you like to log the below configured events?
                        <br/>
                        <type-selector init-id-type="log_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('log_channelid', $serverConfig["log_channelid"]))) }}'
                                       :values='channels'></type-selector>
                        <br/>
                        @include("config.types.bool", ['key' => "embed_logchannel", 'data' => old('embed_logchannel', $serverConfig["embed_logchannel"])])
                        Use Embed with below configured colours
                        <br/><br/>
                        @include("config.types.bool", ['key' => "log_editedmessages", 'data' => old('log_editedmessages', $serverConfig["log_editedmessages"])])
                        Log edited messages.
                        <br/>
                        @include("config.types.bool", ['key' => "log_deletedmessages", 'data' => old('log_deletedmessages', $serverConfig["log_deletedmessages"])])
                        Log deleted messages.
                        <br/>
                        <color-picker input-name="color_logmessages"
                                      hex-value="{{old('color_logmessages', $serverConfig["color_logmessages"])}}"></color-picker>
                        <br/><br/>
                        @include("config.types.bool", ['key' => "log_promotions", 'data' => old('log_promotions', $serverConfig["log_promotions"])])
                        Log the use of the <code>@{{ command_prefix }}join</code> and <code>@{{ command_prefix
                            }}leave</code> commands, as well as the <code>@{{ command_prefix }}promote</code> & <code>@{{
                            command_prefix }}demote</code>.
                        <br/>
                        <color-picker input-name="color_logchannel"
                                      hex-value="{{old('color_logchannel', $serverConfig["color_logchannel"])}}"></color-picker>
                        <br/><br/>
                        <b>Voice Activity Log Channel</b> - logs users joining and leaving voice channels.
                        <br/>
                        <type-selector init-id-type="voice_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('voice_channelid', $serverConfig["voice_channelid"]))) }}'
                                       :values='channels'></type-selector>
                        <br/>
                        @include("config.types.bool", ['key' => "embed_voicechannel", 'data' => old('embed_voicechannel', $serverConfig["embed_voicechannel"])])
                        Use Embed with this colour:
                        <color-picker input-name="color_voicechannel"
                                      hex-value="{{old('color_voicechannel', $serverConfig["color_voicechannel"])}}"></color-picker>
                        <br/>
                    </p>
                    <p>
                        <b>User Activity log channel</b> - In which channel would you like to log the below configured
                        events?
                        <br/>
                        <type-selector init-id-type="activity_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('activity_channelid', $serverConfig["activity_channelid"]))) }}'
                                       :values='channels'></type-selector>
                        <br/>
                        @include("config.types.bool", ['key' => "embed_activitychannel", 'data' => old('embed_activitychannel', $serverConfig["embed_activitychannel"])])
                        Use Embed with this colour:
                        <color-picker input-name="color_activitychannel"
                                      hex-value="{{old('color_activitychannel', $serverConfig["color_activitychannel"])}}"></color-picker>
                        <br/><br/>
                        @include("config.types.bool", ['key' => "log_join", 'data' => old('log_join', $serverConfig["log_join"])])
                        Display the following message when a new user joins your server. Use <code>{0}</code> in the
                        message where their username should be. <i>(Message has to be shorter than 200 characters for embeds to work.)</i>
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "log_message_join", 'data' => old('log_message_join', $serverConfig["log_message_join"])])
                        <br/>
                        @include("config.types.bool", ['key' => "log_mention_join", 'data' => old('log_mention_join', $serverConfig["log_mention_join"])])
                        Mention these people? (Will use only their username if this is <code>false</code>)
                        <br/>
                        @include("config.types.bool", ['key' => "log_timestamp_join", 'data' => old('log_timestamp_join', $serverConfig["log_timestamp_join"])])
                        Display timestamp.
                        <br/><br/>
                        @include("config.types.bool", ['key' => "log_leave", 'data' => old('log_leave', $serverConfig["log_leave"])])
                        Display the following message when someone leaves your server. Use <code>{0}</code> in the
                        message where their username should be. <i>(Message has to be shorter than 200 characters for embeds to work.)</i>
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "log_message_leave", 'data' => old('log_message_leave', $serverConfig["log_message_leave"])])
                        <br/>
                        @include("config.types.bool", ['key' => "log_mention_leave", 'data' => old('log_mention_leave', $serverConfig["log_mention_leave"])])
                        Mention these people? (Will use only their username if this is <code>false</code>)
                        <br/>
                        @include("config.types.bool", ['key' => "log_timestamp_leave", 'data' => old('log_timestamp_leave', $serverConfig["log_timestamp_leave"])])
                        Display timestamp.
                        <br/><br/>
                        <b>Ignored channels</b> - messages deleted or edited in these channels will not be logged and antispam won't take action in these channels.
                        <br />
                        <ignore-channel-list-selector></ignore-channel-list-selector>
                        <br/><br/>
                        {{-- <b>Ignored roles</b> - messages deleted or edited by people with these roles will not be logged and antispam won't take action against them.
                        <br />
                        <role-antispam-selector></role-antispam-selector> --}}
                    </p>
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#configNewUser" aria-expanded="false" aria-controls="configNewUser">
                    New User / Verification
                </button>
                <div class="form-inline form-group collapse" id="configNewUser"><br/>
                    <h2>New User</h2>
                    <div class="features-indent">
                        <b>As soon as they join...</b>
                        <br/>
                        @include("config.types.bool", ['key' => "welcome_pm", 'data' => old('welcome_pm', $serverConfig["welcome_pm"])])
                        PM the following message to the user, when they join your server. Use <code>{0}</code> in the
                        message where their username should be.
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "welcome_message", 'data' => old('welcome_message', $serverConfig["welcome_message"])])
                        <br/><br/>
                        Assign them the following role.
                        <br/>
                        <type-selector init-id-type="welcome_roleid" label="name"
                                       :default-value='{{ json_encode($guild['roles']->get(old('welcome_roleid', $serverConfig["welcome_roleid"]))) }}'
                                       :values='roles'></type-selector>
                    </div>
                    <h2>Kick on failed verification</h2>
                    <div class="features-indent">
                        <b>Kick Without Role</b>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_norole", 'data' => old('antispam_norole', $serverConfig["antispam_norole"])])
                        Kick users if they do not get a role (by verifying via a command, emoji reaction role, or our code verification) a little while after joining. Will not kick anyone who was around for more than one day. Use command to do that: <code>kickWithoutRoles</code>
                        <br/>
                        The time between they join and get kicked out in minutes:
                        <br/>
                        @include("config.types.int", ['key' => "antispam_norole_minutes", 'data' => old('antispam_norole_minutes', $serverConfig["antispam_norole_minutes"])])
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_norole_recent", 'data' => old('antispam_norole_recent', $serverConfig["antispam_norole_recent"])])
                        Only recently created accounts - apply the Account Age configured below.
                        <br/>
                        @include("config.types.bool", ['key' => "log_antispam_kick", 'data' => old('log_antispam_kick', $serverConfig["log_antispam_kick"])])
                        Log these into the User Activity log channel (requires it to be configured in the Logging section above.)
                    </div>
                    <h2>Verification</h2>
                    <div class="features-indent">
                        <b>Discord's Native Gating</b>
                        <br/>
                        @include("config.types.bool", ['key' => "native_gating", 'data' => old('native_gating', $serverConfig["native_gating"])])
                        Assign the below configured Verification role (and count it towards the <code>stats</code>) when a new member joins and completes Discord's native "Membership Screening" feature.
                        <br/><br/>
                        <b>Captcha Verification</b> (..kinda!)
                        <br/>
                        @include("config.types.bool", ['key' => "captcha", 'data' => old('captcha', $serverConfig["captcha"])])
                        The bot will send a simple ascii art animal to the user via PM and they have to identify it. Upon success the user is assigned below configured role and cookies.
                        <br/><br/>
                        <b>Find-a-Code Verification</b>
                        <br/>
                        @include("config.types.bool", ['key' => "verify", 'data' => old('verify', $serverConfig["verify"])])
                        The bot will send information how to get verified to the user via PM together with your rules
                        (configured below) and a hidden code within the text. They will be assigned Verified Role after
                        they find the code and reply with it back to the bot. We recommend to give this role normal
                        permissions, while the <code>@everyone</code> role should have just basic read permissions and
                        be unable to speak, upload files, etc...
                        <br/><br/>
                        This message will be included in the instructions PMed to the user. If you are using Reddit, you
                        can just list the benefits (extra permissions) of the verification, or in case of the Code
                        Verification, we recommend using well crafted rules, such as the ones in the <a
                                href="http://rhea-ayase.eu/articles/2017-04/Moderation-guidelines" target="_blank">Moderation
                            Guidelines</a> written by Rhea.
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "verify_message", 'data' => old('verify_message', $serverConfig["verify_message"])])
                    </div>
                    <h2>Common verification options</h2>
                    <div class="features-indent">
                        <b>Send pm automatically</b>
                        <br/>
                        @include("config.types.bool", ['key' => "verify_on_welcome", 'data' => old('verify_on_welcome', $serverConfig["verify_on_welcome"])])
                        Send the verification info to the user as soon as they join the server. You can also send it to
                        them using <code>@{{ command_prefix }}verify @user</code> or they can request it be sent with
                        <code>@{{ command_prefix }}verify</code> without parameters.
                        <br/><br/>
                        <b>Failed PM channel</b>
                        <br/>
                        Should the PM fail due to their privacy settings, Valkyrja can notify them about it in this channel:
                        <br/>
                        <type-selector init-id-type="verify_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('verify_channelid', $serverConfig["verify_channelid"]))) }}'
                                       :values='channels'></type-selector>
                        <br/><br/>
                        <b>Account age</b>
                        <br/>
                        @include("config.types.bool", ['key' => "verify_accountage", 'data' => old('verify_accountage', $serverConfig["verify_accountage"])])
                        Automatically assign the below configured veirifcation Role to accounts older than this time many days:
                        <br/>
                        @include("config.types.int", ['key' => "verify_accountage_days", 'data' => old('verify_accountage_days', $serverConfig["verify_accountage_days"])])
                        <br/><br/>
                        <b>Role</b>
                        <br/>
                        Assign the following role to verified users.
                        <br/>
                        <type-selector init-id-type="verify_roleid" label="name"
                                       :default-value='{{ json_encode($guild['roles']->get(old('verify_roleid', $serverConfig["verify_roleid"]))) }}'
                                       :values='roles'></type-selector>
                        <br/>
                        (Recommended permissions: <a href="/img/verifyRole.png" target="_blank">Verified Role</a> and <a
                                href="/img/verifyEveryone.png" target="_blank">@everyone</a>)
                        <br/><br/>
                        <b>Cookies</b>
                        <br/>
                        How many {{ $serverConfig["karma_currency"] }} do you want to give them? Use <code>0</code>
                        (zero) to disable. This also depends on whether your karma system is enabled or not.
                        <br/>
                        @include("config.types.int", ['key' => "verify_karma", 'data' => old('verify_karma', $serverConfig["verify_karma"])])
                        <br/><br/>
                        <b>Statistics</b>
                        <br/>
                        @include("config.types.bool", ['key' => "stats", 'data' => old('stats', $serverConfig["stats"])])
                        Enable verification statistics - this will keep track of how many people joined, left on their own, got banned by Valk's antispam, got kicked out by the above failed verification, and how many were removed by Discord itself. Use <code>@{{ command_prefix}}stats</code>
                        <br/>
                        You can even set-up the role above even if it's assigned by different bot or any other verification system, and it will be tracked.
                        <br/><br/>
                        <b>Manual Verification</b>
                        <br/>
                        If you need to verify someone manually, you can use the verify command with <code>force</code>
                        parameter, such as this:
                        <br/>
                        <code>@{{ command_prefix }}verify @Rhea force</code>
                    </div>
                </div>
                <button class="btn btn-fading btn-full-width"  type="button" data-toggle="collapse"
                        data-target="{{ $isPremium ? "#configSocial" : "#subscribeConfigSocial"}}" aria-expanded="false" aria-controls="{{ $isPremium ? "configSocial" : "subscribeConfigSocial"}}">
                    Social (profiles, levels & karma)
                </button>
                <div class="form-inline form-group collapse" id="subscribeConfigSocial">
                    <a class="d-block text-center" href="https://www.github.com/sponsors/RheaAyase" target="_blank">Subscribe to utilize Social features.</a>
                </div>
                <div class="form-group collapse {{ !$isPremium ? "hide-section" : ""}}" id="configSocial"><br />
                    <p class="form-inline">
                        @include("config.types.bool", ['key' => "memo_enabled", 'data' => old('memo_enabled', $serverConfig["memo_enabled"])])
                        <b>Enable <code>@{{ command_prefix }}memo</code></b>
                    </p>
                    <p>
                        <span class="form-inline">
                           @include("config.types.bool", ['key' => "profile_enabled", 'data' => old('profile_enabled', $serverConfig["profile_enabled"])])
                        </span>
                        <b>Enable profiles</b>
                        <br>
                        <a href="/img/profiles.png">See profiles in action here.</a>
                        <br>
                        Setup profile fields in the editor below.
                        <br>
                        <profiles-editor form-name="profile_options"></profiles-editor>
                    </p>
                    <p>
                        Optional introduction channel for <code>@{{ command_prefix }}sendProfile</code> command, which will allow users to display their profile in this channel.
                        <br />
                        <type-selector init-id-type="profile_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('profile_channelid', $serverConfig["profile_channelid"]))) }}'
                                       :values='channels'></type-selector>
                    </p>
                    <p class="form-inline">
                        <b>Activity Member role</b>
                        <br />Some servers prefer to (mis)use experience system to merely assign a member role after user shows some activity - sends a few messages. Please consider using the above verification system, and if that is not what you're after, use this instead of the experience system.
                        <br />Member role to be assigned:
                        <br />
                        <type-selector init-id-type="exp_member_roleid" label="name"
                                       :default-value='{{ json_encode($guild['roles']->get(old('exp_member_roleid', $serverConfig["exp_member_roleid"]))) }}'
                                       :values='roles'></type-selector>
                        <br /><br />
                        Number of messages a user has to send to get the above Member role (<i>Leave this at zero to disable it.</i>)
                        <br />@include("config.types.int", ['key' => "exp_member_messages", 'data' => old('exp_member_messages', $serverConfig["exp_member_messages"])])
                    </p>
                    <p class="form-inline">
                        <b>Experience & levels</b>
                        <br />Users earn experience based on the below configuration and they are granted levels, which may or may not have roles associated with them.
                        <br />Take a look at the <a href="https://docs.google.com/spreadsheets/d/1w-eZn3b8FgjQkM6FS1q6q5XU6epvbJbmH74IMgRUke4">progression table</a>.
                        <br /><i>(Please don't enter stupid (high) numbers, you will only break it on your end.)</i>
                        <br /><br />
                        @include("config.types.bool", ['key' => "exp_enabled", 'data' => old('exp_enabled', $serverConfig["exp_enabled"])])
                        <b>Experience Enabled</b>
                        <br /><br />
                        @include("config.types.bool", ['key' => "exp_ignored_channels", 'data' => old('exp_ignored_channels', $serverConfig["exp_ignored_channels"])])
                        Apply ignored channels from the logging config section
                        <br /><br />
                        @include("config.types.bool", ['key' => "exp_announce_levelup", 'data' => old('exp_announce_levelup', $serverConfig["exp_announce_levelup"])])
                        Announce level-up
                        <br /><br />
                        Base experience value (<code>baseExp</code>) <i>Higher value means slower progression, default <code>10</code></i>.
                        <br />@include("config.types.int", ['key' => "base_exp_to_levelup", 'data' => old('base_exp_to_levelup', $serverConfig["base_exp_to_levelup"])])
                        <br /><br />
                        Experience given per message (<code>expPerMessage</code>) <i>Higher value means faster progression, default <code>1</code></i>.
                        <br />@include("config.types.int", ['key' => "exp_per_message", 'data' => old('exp_per_message', $serverConfig["exp_per_message"])])
                        <br /><br />
                        Experience given per image (attachment) (<code>expPerImage</code>) <i>Higher value means faster progression, default <code>3</code></i>.
                        <br />@include("config.types.int", ['key' => "exp_per_attachment", 'data' => old('exp_per_attachment', $serverConfig["exp_per_attachment"])])
                        <br /><br />
                        Maximum level - set to <code>0</code> (zero) to disable.
                        <br />@include("config.types.int", ['key' => "exp_max_level", 'data' => old('exp_max_level', $serverConfig["exp_max_level"])])
                        <br /><br />
                        Roles at levels
                        <br />
                        <level-selector>
                            <template slot-scope="props">
                                <span v-for="role in props.typeAdded">
                                    <input type="hidden"
                                           :name="'levels['+props.typeAdded.indexOf(role)+'][roleid]'"
                                           :value="role.roleid">
                                    <input type="hidden"
                                           :name="'levels['+props.typeAdded.indexOf(role)+'][level]'"
                                           :value="role.level">
                                </span>
                            </template>
                        </level-selector>
                        @include("config.types.bool", ['key' => "exp_cumulative_roles", 'data' => old('exp_cumulative_roles', $serverConfig["exp_cumulative_roles"])])
                        Are these roles cumulative? (<code>true</code> - all the roles are assigned for all the previous levels; <code>false</code> - only one role will be assigned and the previous level roles will be removed.)
                        <br /><br />
                        @include("config.types.bool", ['key' => "exp_advance_users", 'data' => old('exp_advance_users', $serverConfig["exp_advance_users"])])
                        Valkyrja can advance users to the above configured highest role. This means that if a user already has a higher level role, than their level, their level will be increased to match the role. This is useful if you are transitioning from other level systems, this way your users won't lose their progress!
                        <br /><br />
                        How many {{ $serverConfig["karma_currency"] }} do you want to give them every level-up? (this will scale up for higher levels.) Use <code>0</code> (zero) to disable. This also depends on whether your karma system is enabled or not.
                        <br />@include("config.types.int", ['key' => "karma_per_level", 'data' => old('karma_per_level', $serverConfig["karma_per_level"])])
                    </p>
                    <p class="form-inline">
                        <b>Karma system</b>
                        <br />Karma is an extra appreciation of helpful people. They get thanked, they get a cookie!
                        <br /><code>Rhea: Hey thanks for that pull request fixing a typo @freiheit</code>
                        <br /><code>Valkyrja: @freiheit received a <i>thank you</i> cookie!</code>
                        <br />You can also <code>!give @user</code> a cookie, however, this will take one of yours. You can eat them as well. Many details can be customized below...
                        <br /><i>Hint: Create <code>@{{ command_prefix }}alias</code> for the <code>cookies</code> and <code>nom</code> commands to fit your custom configuration below!</i>
                        <br />
                        @include("config.types.bool", ['key' => "karma_enabled", 'data' => old('karma_enabled', $serverConfig["karma_enabled"])])
                        Use Karma system?
                        <br /><br />
                        Currency plural (Definitely cookies!)
                        <br />
                        @include("config.types.text", ['key' => "karma_currency", 'data' => old('karma_currency', $serverConfig["karma_currency"])]) (This is also a command to check your <i>{{ $serverConfig["karma_currency"] }}</i>)
                        <br />
                        Currency singular
                        <br />
                        @include("config.types.text", ['key' => "karma_currency_singular", 'data' => old('karma_currency_singular', $serverConfig["karma_currency_singular"])])
                        <br /><br />
                        If you've changed the consume command <code>nom</code> by creating an alias, please specify it here. <i>(Eating a cookie is selfish act and will effectively reduce the number you have by one.)</i>
                        <br />
                        @include("config.types.text", ['key' => "karma_consume_command", 'data' => old('karma_consume_command', $serverConfig["karma_consume_command"])])
                        <br /><br />
                        Consume verb used in response to the <code>@{{ command_prefix }}nom</code> command. Past tense please.
                        <br />
                        @include("config.types.text", ['key' => "karma_consume_verb", 'data' => old('karma_consume_verb', $serverConfig["karma_consume_verb"])])
                        <br /><br />
                        How many people can be mentioned at the same time, to give them <i>cookies</i>?
                        <br />
                        @include("config.types.int", ['key' => "karma_limit_mentions", 'data' => old('karma_limit_mentions', $serverConfig["karma_limit_mentions"])])
                        <br />
                        How often can someone <i>thank</i> others to give them <i>cookies</i>? (Consider this number a thankyou-cooldown in minutes.)
                        <br />
                        @include("config.types.int", ['key' => "karma_limit_minutes", 'data' => old('karma_limit_minutes', $serverConfig["karma_limit_minutes"])])
                        <br />
                        @include("config.types.bool", ['key' => "karma_limit_response", 'data' => old('karma_limit_response', $serverConfig["karma_limit_response"])])
                        Tell people if they exceed this limit?
                    <br />
                    </p>
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#customCommands" aria-expanded="false" aria-controls="customCommands">
                    Custom Commands
                </button>
                <div class="form-group collapse" id="customCommands">
                    <p>
                        <custom-commands form-name="custom_commands"></custom-commands>
                    </p>
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#localisation" aria-expanded="false" aria-controls="localisation">
                    Localisation
                </button>
                <div class="form-inline form-group collapse" id="localisation">
                    <p>
                        <custom-localisation :init-localisation-id="{{ old('localisation_id', $serverConfig["localisation_id"]) }}"></custom-localisation>
                    </p>
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#otherstuff" aria-expanded="false" aria-controls="otherstuff">
                    Other...
                </button>
                <div class="form-inline form-group collapse" id="otherstuff">
                    <p class="form-inline">
                        <b>Temporary Voice Channels</b> (<code>@{{ command_prefix }}tempChannel</code> or <code>@{{ command_prefix }}tmp</code>)
                        <br/>
                        Channel category for the temporary voice channels
                        <br/>
                        <type-selector init-id-type="tempchannel_categoryid" label="name"
                                       :default-value='{{ json_encode($guild['categories']->get(old('tempchannel_categoryid', $serverConfig["tempchannel_categoryid"]))) }}'
                                       :values='categories'></type-selector>
                        <br/>
                        @include("config.types.bool", ['key' => "tempchannel_giveadmin", 'data' => old('tempchannel_giveadmin', $serverConfig["tempchannel_giveadmin"])])
                        Give the creator of a temporary voice channel permissions to modify the channel, and to move and mute people?
                        <br/><br/>
                        <b>Auto-announced channels</b><br/>
                        Choose announcement channels that are to be automatically Published. (Requires <code>Send</code> & <code>Manage Messages</code> permissions.)
                        <br />
                        <auto-announce-channel-list-selector>
                            <template slot-scope="added">
                                <span v-for="channel in added.added">
                                    <input type="hidden"
                                           :name="'channels['+added.added.indexOf(channel)+'][channelid]'"
                                           :value="channel.channelid">
                                    <input type="hidden"
                                           :name="'channels['+added.added.indexOf(channel)+'][ignored]'"
                                           :value="Number(channel.ignored)">
                                    <input type="hidden"
                                           :name="'channels['+added.added.indexOf(channel)+'][auto_announce]'"
                                           :value="Number(channel.auto_announce)">
                                </span>
                            </template>
                        </auto-announce-channel-list-selector>
                    </p>
                </div>
                {{ csrf_field() }}
                <span class="col-md-5">
                  <table><tr>
                    <td style="vertical-align:middle; width:auto">
                      <button class="btn btn-primary" type="button" :disabled="anyLoading" @click="onSubmit">Save</button>
                    </td>
                    <td style="vertical-align:middle; width:20px">
                        <tos-field></tos-field>
                    </td>
                    <td style="vertical-align:middle; width:auto; font-size:10pt">
                        By using the Valkyrja bot you agree to storing End User data (in compliance with Discord ToS) necessary for the functionality as configured on this website.
                    </td>
                  </tr></table>
                </span>
            </form>
        </div>
    </div>
@endsection
