@extends('layouts.master')

@section('title', 'Config')

@section('header')
    <script type="application/javascript">
        window.__INITIAL_STATE__ = "{!! addslashes(json_encode([
			'channels' => array_values($guild['channels']->all()),
			'roles' => array_values($guild['roles']->all()),
			'custom_commands' => old('custom_commands', (isset($errors) && count($errors) > 0) ? [] : $customCommands->all()),
			'rolesData' => old('roles', (isset($errors) && count($errors) > 0) ? [] : $roles->all()),
			'channelsData' => old('channels', (isset($errors) && count($errors) > 0) ? [] : $channels->all()),
        ])) !!}"
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="col-xs-12">
            <form action="{{ url('config/'.$serverId) }}" method="post" @submit.prevent>
                <h1 class="col-md-8">
                    <v-loading message='Configure Botwinder'>
                    <span slot='spinner' class="align-bottom">
                        <v-loading-spinner width='1em' height='1em'></v-loading-spinner>
                    </span>
                        <span>Configure Botwinder</span>
                    </v-loading>
                </h1>
                <span class="col-md-4">
				<button class="btn btn-primary float-right" type="button" :disabled="anyLoading"
                        @click="onSubmit">Save</button>
			</span>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#configBasic" aria-expanded="true" aria-controls="configBasic">
                    Basic configuration
                </button>
                <div class="form-inline form-group collapse in" id="configBasic"><br/>
                    <p>
                        <b>Permissions</b>
                        <br/>
                        Botwinder expects server and channel permissions to be correct and some functions may not work
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
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#configAntispam" aria-expanded="false" aria-controls="configAntispam">
                    Antispam
                </button>
                <div class="form-inline form-group collapse" id="configAntispam"><br/>
                    <p>
                        Botwinder will act as configured below, if it takes any action, it will PM the naughty user
                        letting them know about it. If you configure it to also ban for excessive spam, it will let the
                        user know one message before banning them. Removed messages and banned users will be logged as
                        configured in the <code>Moderation Log</code> section.
                        <br/>
                        Antispam will not take any action against Admins or Moderators. You should also configure <code>Ignore
                            Channels</code> in the Logging section - Antispam will not be active in these channels.
                        <br/>
                        <i>Antispam will not even try to do anything if the bot does not have
                            <code>ManageMessages</code> & <code>Ban</code> permissions.</i>
                    </p>
                    <p>
                        Remember that you can <code>@{{ command_prefix }}permit @people</code> to allow anyone mentioned
                        to post a single link or anything else in this section, for three minutes.
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
                    <p>
                        <b>Automated ban</b>
                        <br/>
                        If you do not want the bot to ban people for spamming, set this to <code>0</code> (zero)
                        otherwise set a number of how many spammy messages should we tolerate before banning them.
                        Spammy messages = links or anything else in this section below, while all the options below do
                        have a ban option for this as well.
                        <br/>
                        <text-field init-id="antispam_tolerance" init-name="antispam_tolerance"
                                    init-value="{{ old('antispam_tolerance', $serverConfig["antispam_tolerance"]) }}"></text-field>
                    </p>
                    <p>
                        <b>Discord Invites</b>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_invites", 'data' => old('antispam_invites', $serverConfig["antispam_invites"])])
                        Remove messages that contain discord invites?
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_invites_ban", 'data' => old('antispam_invites_ban', $serverConfig["antispam_invites_ban"])])
                        Ban people after <code>@{{ antispam_tolerance }}</code> invites have been removed?
                    </p>
                    <p>
                        <b>Duplicate messages</b>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_duplicate", 'data' => old('antispam_duplicate', $serverConfig["antispam_duplicate"])])
                        Remove duplicate messages? Also known as <i>literally spam</i>.
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_duplicate_crossserver", 'data' => old('antispam_duplicate_crossserver', $serverConfig["antispam_duplicate_crossserver"])])
                        We can also remove these cross-server. Imagine that there is someone going through many servers
                        and posting some advertisement everywhere, but only a single message per-server so it doesn't
                        count as standard spam. Botwinder would notice these messages as being duplicates between
                        servers.
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_duplicate_ban", 'data' => old('antispam_duplicate_ban', $serverConfig["antispam_duplicate_ban"])])
                        Ban people after <code>@{{ antispam_tolerance }}</code> messages have been removed?
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
                        Ban people after <code>@{{ antispam_tolerance }}</code> messages have been removed?
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
                        Requires <code>Muted Role</code> to be configured in the <code>Moderation</code> section, where
                        you can also change the duration of the mute. <i>Scroll down</i>
                        <br/><br/>
                        <b>Mute</b>
                        <br/>
                        Duration of the mute.
                        <br/>
                        @include("config.types.int", ['key' => "antispam_mute_duration", 'data' => old('antispam_mute_duration', $serverConfig["antispam_mute_duration"])])
                        (minutes)
                    </p>
                    <p>
                        <b>YouTube links</b>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_youtube", 'data' => old('antispam_links_youtube', $serverConfig["antispam_links_youtube"])])
                        Remove YouTube links?
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_youtube_ban", 'data' => old('antispam_links_youtube_ban', $serverConfig["antispam_links_youtube_ban"])])
                        Ban people after <code>@{{ antispam_tolerance }}</code> links have been removed?
                    </p>
                    <p>
                        <b>Twitch links</b>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_twitch", 'data' => old('antispam_links_twitch', $serverConfig["antispam_links_twitch"])])
                        Remove Twitch links?
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_twitch_ban", 'data' => old('antispam_links_twitch_ban', $serverConfig["antispam_links_twitch_ban"])])
                        Ban people after <code>@{{ antispam_tolerance }}</code> links have been removed?
                    </p>
                    <p>
                        <b>Hitbox/Smashcast links</b>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_hitbox", 'data' => old('antispam_links_hitbox', $serverConfig["antispam_links_hitbox"])])
                        Remove Hitbox and Smashcast links?
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_hitbox_ban", 'data' => old('antispam_links_hitbox_ban', $serverConfig["antispam_links_hitbox_ban"])])
                        Ban people after <code>@{{ antispam_tolerance }}</code> links have been removed?
                    </p>
                    <p>
                        <b>Beam/Mixer links</b>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_beam", 'data' => old('antispam_links_beam', $serverConfig["antispam_links_beam"])])
                        Remove Beam and Mixer links?
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_beam_ban", 'data' => old('antispam_links_beam_ban', $serverConfig["antispam_links_beam_ban"])])
                        Ban people after <code>@{{ antispam_tolerance }}</code> links have been removed?
                    </p>
                    <p>
                        <b>Imgur-like links</b>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_imgur", 'data' => old('antispam_links_imgur', $serverConfig["antispam_links_imgur"])])
                        Remove imgur, gfycat, giphy or tinypic links?
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_imgur_ban", 'data' => old('antispam_links_imgur_ban', $serverConfig["antispam_links_imgur_ban"])])
                        Ban people after <code>@{{ antispam_tolerance }}</code> links have been removed?
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
                        Ban people after <code>@{{ antispam_tolerance }}</code> links have been removed?
                    </p>
                    <p>
                        <b>Extended links</b>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_extended", 'data' => old('antispam_links_extended', $serverConfig["antispam_links_extended"])])
                        Remove Extended links? Extended links are basically <code>anything.anything</code>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_links_extended_ban", 'data' => old('antispam_links_extended_ban', $serverConfig["antispam_links_extended_ban"])])
                        Ban people after <code>@{{ antispam_tolerance }}</code> links have been removed?
                    </p>
                    <p>
                        <b>Voice Channel switching</b>
                        <br/>
                        @include("config.types.bool", ['key' => "antispam_voice_switching", 'data' => old('antispam_voice_switching', $serverConfig["antispam_voice_switching"])])
                        Warn and ban (for one hour) people who spam-switch voice channels.
                    </p>
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#configModeration" aria-expanded="false" aria-controls="configModeration">
                    Moderation
                </button>
                <div class="form-inline form-group collapse" id="configModeration"><br/>
                    <p>
                        <b>Roles</b>
                        <br/>
                        Roles that will have different kind of permissions - refer to the documentation to see what can
                        each permission do. (You can also customize that using the <code>@{{ command_prefix
                            }}permissions</code> command.)
                        <br/>
                        Public Roles default to <code>No group</code> where any user can <code>@{{ command_prefix
                            }}join</code> any of these roles. Any other public role group will be exclusive, and the
                        user can have only one role out of a group at the time. You can have multiple groups.
                        <br/>
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
                                </span>
                            </template>
                        </role-selector>
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
                    </p>
                    <p>
                        <b>Quickban</b>
                        <br/>
                        Should you wish to use the <code>@{{ command_prefix }}quickban</code> you have to configure the
                        reason why are you banning the user. This will be PMed them just like with standard <code>@{{
                            command_prefix }}ban</code>. We recommend something like <code>Ignoring the rules / spamming
                            inappropriate content.</code> (The command will be disabled if you leave this field empty.)
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "quickban_reason", 'data' => old('quickban_reason', $serverConfig["quickban_reason"])])
                        <br/><br/>
                        And for how long do you want to ban them using this command? Set <code>0</code> (zero) for
                        permanent ban.
                        <br/>
                        @include("config.types.int", ['key' => "quickban_duration", 'data' => old('quickban_duration', $serverConfig["quickban_duration"])])
                        (hours)
                    </p>
                    <p>
                        <code>Muted Role</code> - Role that will be used for the purpose of muting people, this role
                        will be configured by Botwinder to prevent people from talking in all your channels.
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
                        <b>How does the Mute system work</b>
                        <br/>
                        It is important that you understand how does the Muting system work:<br/>
                        Regardless of how is the user muted, they get unmuted next time the bot restarts, this is to
                        ensure that nobody is left hanging, because it is supposed to be a timed feature.
                        Now if someone leaves and then rejoins the server, they will be Muted again, and this time it is
                        treated as an antispam mute, which means that the third one will get you banned. So cheating to
                        get rid of the "mute" role is really bad idea and if the <i>victim</i> leaves and joins the
                        server twice while they are muted, they get banned.
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
                        Another article about moderating a community, full of Discord/Botwinder examples. <i>(Written by
                            Rhea.)</i>
                    </p>
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#configLogging" aria-expanded="false" aria-controls="configLogging">
                    Logging
                </button>
                <div class="form-inline form-group collapse" id="configLogging"><br/>
                    <p>
                        @include("config.types.bool", ['key' => "log_bans", 'data' => old('log_bans', $serverConfig["log_bans"])])
                        <b>Moderation Log Channel</b> - Log muted, kicked and banned users into the following channel.
                        <br/>
                        <type-selector init-id-type="mod_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('mod_channelid', $serverConfig["mod_channelid"]))) }}'
                                       :values='channels'></type-selector>
                        <br/>
                        @include("config.types.bool", ['key' => "embed_modchannel", 'data' => old('embed_modchannel', $serverConfig["embed_modchannel"])])
                        Use Embed with this colour:
                        <color-picker input-name="color_modchannel"
                                      hex-value="{{old('color_modchannel', $serverConfig["color_modchannel"])}}"></color-picker>
                        <br/><br/>
                        <b>Log Channel</b> - In which channel would you like to log the below configured events?
                        <br/>
                        <type-selector init-id-type="log_channelid" label="name"
                                       :default-value='{{ json_encode($guild['channels']->get(old('log_channelid', $serverConfig["log_channelid"]))) }}'
                                       :values='channels'></type-selector>
                        <br/>
                        @include("config.types.bool", ['key' => "embed_logchannel", 'data' => old('embed_logchannel', $serverConfig["embed_logchannel"])])
                        Use Embed
                        <br/>
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
                        message where their username should be.
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
                        message where their username should be.
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "log_message_leave", 'data' => old('log_message_leave', $serverConfig["log_message_leave"])])
                        <br/>
                        @include("config.types.bool", ['key' => "log_mention_leave", 'data' => old('log_mention_leave', $serverConfig["log_mention_leave"])])
                        Mention these people? (Will use only their username if this is <code>false</code>)
                        <br/>
                        @include("config.types.bool", ['key' => "log_timestamp_leave", 'data' => old('log_timestamp_leave', $serverConfig["log_timestamp_leave"])])
                        Display timestamp.
                        <br/><br/>
                        <b>Ignore channels</b> - messages deleted or edited in these channels will not be logged.
                        <br />
                        <ignore-channel-list-selector>
                            <template slot-scope="added">
                                <span v-for="channel in added.added">
                                    <input type="hidden"
                                           :name="'channels['+added.added.indexOf(channel)+'][channelid]'"
                                           :value="channel.channelid">
                                    <input type="hidden"
                                           :name="'channels['+added.added.indexOf(channel)+'][ignored]'"
                                           :value="Number(channel.ignored)">
                                </span>
                            </template>
                        </ignore-channel-list-selector>
                    </p>
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse"
                        data-target="#configNewUser" aria-expanded="false" aria-controls="configNewUser">
                    New User / Verification
                </button>
                <div class="form-inline form-group collapse" id="configNewUser"><br/>
                    <p><br/>
                        <b>New User</b>
                        <br/><br/>
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
                    </p>
                    <br/>
                    <p>
                        <br/><br/>
                        <b>Code Verification</b>
                        <br/>
                        The bot will send information how to get verified to the user via PM together with your rules
                        (configured below) and a hidden code within the text. They will be assigned Verified Role after
                        they find the code and reply with it back to the bot. We recommend to give this role normal
                        permissions, while the <code>@everyone</code> role should have just basic read permissions and
                        be unable to speak, upload files, etc...
                        <br/><br/>
                        @include("config.types.bool", ['key' => "verify", 'data' => old('verify', $serverConfig["verify"])])
                        Enable verification system.
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
                        This message will be included in the instructions PMed to the user. If you are using Reddit, you
                        can just list the benefits (extra permissions) of the verification, or in case of the Code
                        Verification, we recommend using well crafted rules, such as the ones in the <a
                                href="http://rhea-ayase.eu/articles/2017-04/Moderation-guidelines" target="_blank">Moderation
                            Guidelines</a> written by Rhea.
                        <br/>
                        @include("config.types.multi-line-text", ['key' => "verify_message", 'data' => old('verify_message', $serverConfig["verify_message"])])
                        <br/><br/>
                        @include("config.types.bool", ['key' => "verify_on_welcome", 'data' => old('verify_on_welcome', $serverConfig["verify_on_welcome"])])
                        Send the verification info to the user, as soon as they join the server. You can also send it to
                        them using <code>@{{ command_prefix }}verify @user</code> or they can request it be sent with
                        <code>@{{ command_prefix }}verify</code> without parameters.
                        <br/><br/>
                        How many {{ $serverConfig["karma_currency"] }} do you want to give them? Use <code>0</code>
                        (zero) to disable. This also depends on whether your karma system is enabled or not.
                        <br/>
                        @include("config.types.int", ['key' => "verify_karma", 'data' => old('verify_karma', $serverConfig["verify_karma"])])
                        <br/><br/>
                        If you need to verify someone manually, you can use the verify command with <code>force</code>
                        parameter, such as this:
                        <br/>
                        <code>@{{ command_prefix }}verify @Rhea force</code>
                    </p>
                </div>
                <button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse" data-target="#configSocial" aria-expanded="false" aria-controls="configSocial">
                    Social (levels & karma)
                </button>
                <div class="form-inline form-group collapse" id="configSocial"><br />
                    <p>
                        <b>Experience & levels</b>
                        <br />Users earn experience based on the below configuration and they are granted levels, which may or may not have roles associated with them.
                        <br />
                        <br />You can use this formula to be able get a better idea about the progression curve:
                        <br /><code>lvl = (sqrt(4*totalExp + base) / sqrt(base) - 1) / 2</code>
                        <br /><code>totalExp = baseExp * lvl * (lvl + 1)</code>
                        <br /><code>expToNextLvl = (baseExp * (lvl+1) * ((lvl+1) + 1) - currentTotalExp</code>
                        <br /><code>messagesToNextLvl = expToNextLvl / expPerMessage</code>
                        <br /><code>imagesToNextLvl = expToNextLvl / expPerImage</code>
                        <br /><i>Based on the above complexity we recommend leaving the default values. (Please do not enter stupid (high) numbers, you will only break it on your end.)</i>
                        <br /><br />
                        @include("config.types.bool", ['key' => "exp_enabled", 'data' => old('exp_enabled', $serverConfig["exp_enabled"])])
                        <b>Experience Enabled</b>
                        <br /><br />
                        @include("config.types.bool", ['key' => "exp_announce_levelup", 'data' => old('exp_announce_levelup', $serverConfig["exp_announce_levelup"])])
                        Announce level-up
                        <br /><br />
                        Base experience value (<code>baseExp</code>) _Higher value means slower progression, default <code>10</code>._
                        <br />@include("config.types.int", ['key' => "base_exp_to_levelup", 'data' => old('base_exp_to_levelup', $serverConfig["base_exp_to_levelup"])])
                        <br /><br />
                        Experience given per message (<code>expPerMessage</code>) _Higher value means faster progression, default <code>1</code>._
                        <br />@include("config.types.int", ['key' => "exp_per_message", 'data' => old('exp_per_message', $serverConfig["exp_per_message"])])
                        <br /><br />
                        Experience given per image (attachment) (<code>expPerImage</code>) _Higher value means faster progression, default <code>3</code>._
                        <br />@include("config.types.int", ['key' => "exp_per_attachment", 'data' => old('exp_per_attachment', $serverConfig["exp_per_attachment"])])
                        <br /><br />
                        Roles at levels
                        <br />
                        <i>TODO: This feature is work in progress!!</i>
                        <br />
                        @include("config.types.bool", ['key' => "exp_cumulative_roles", 'data' => old('exp_cumulative_roles', $serverConfig["exp_cumulative_roles"])])
                        Are these roles cumulative? (<code>true</code> - all the roles are assigned for all the previous levels; <code>false</code> - only one role will be assigned and the previous level roles will be removed.)
                        <br /><br />
                        How many {{ $serverConfig["karma_currency"] }} do you want to give them every levle-up? (this will scale up for higher levels.) Use <code>0</code> (zero) to disable. This also depends on whether your karma system is enabled or not.
                        <br />@include("config.types.int", ['key' => "karma_per_level", 'data' => old('karma_per_level', $serverConfig["karma_per_level"])])
                    </p>
                    <p>
                        <b>Karma system</b>
                        <br />Karma is an extra appreciation of helpful people. They get thanked, they get a cookie!
                        <br /><code>Rhea: Hey thanks for that pull request fixing a typo @freiheit</code>
                        <br /><code>Botwinder: @freiheit received a <i>thank you</i> cookie!</code>
                        <br />You can also <code>!give @user</code> a cookie, however, this will take one of yours. You can eat them as well. Many details can be customized below...
                        <br /><i>Hint: Create <code>@{{ command_prefix }}alias<code> for the <code>cookies</code> and <code>nom</code> commands to fit your custom configuration below!</i>
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
                        Consume command - eating a cookie is selfish act and will effectively reduce the number you have by one.
                        <br />
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
                {{ csrf_field() }}
                <button class="btn btn-primary" type="button" :disabled="anyLoading" @click="onSubmit">Save</button>
            </form>
        </div>
    </div>
@endsection
