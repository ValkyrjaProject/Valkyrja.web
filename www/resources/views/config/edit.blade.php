@extends('layouts.master')

@section('title', 'Config')

@section('content')
<div class="container">
	<div class="col-xs-12">
		<form action="{{ url('config/save/'.$serverId) }}" method="post" @submit.prevent>
			<h1 class="col-md-8">
                <v-loading message='Configure Botwinder'>
                    <span slot='spinner' class="align-bottom">
                        <v-loading-spinner width='1em' height='1em' ></v-loading-spinner>
                    </span>
                    <span>Configure Botwinder</span>
                </v-loading>
            </h1>
			<span class="col-md-4">
				<button class="btn btn-primary float-right" type="button" :disabled="anyLoading" @click="onSubmit">Save</button>
			</span>
			<button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse" data-target="#configBasic" aria-expanded="true" aria-controls="configBasic">
				Basic configuration
			</button>
			<div class="form-inline form-group collapse in" id="configBasic"><br />
                <p>
					<b>Permissions</b>
                    <br />
					Botwinder expects server and channel permissions to be correct and some functions may not work if you do not pay enough attention to this topic.
                    <br />
                    First permissions of the bot - you have to not only give it the permissions but also <a href="http://i.imgur.com/T8MPvME.png" target="_blank">to move it up in the <u>roles hierarchy</u></a>. The bot can only assign roles to, and kick or ban users that are below his own role.
                    <br />
                    Second common mistake is wallpapering (to some degree) channel permissions. This may prevent the bot from talking - executing commands, this may also block it from correctly handling channel or user mute, etc. Read <a href="http://rhea-ayase.eu/articles/2016-12/Discord-Guide-Server-setup-and-permissions" target="_blank">this guide about permissions</a>.
				</p>
				<p>
					<b>Command Prefix</b> - required option, do not leave this empty!<br />
					<text-field init-id="CommandCharacter" init-name="CommandCharacter" init-value="{{ $configData["CommandCharacter"][0] }}"></text-field>
				</p>
				<p>
					<b>Alternative Command Prefix</b> - will be used as well as the above, you can leave this one empty.<br />
					@include("config.types.text", ['key' => "AltCommandPrefix", 'data' => $configData["AltCommandPrefix"][0]])
				</p>
				<p>
					@include("config.types.bool", ['key' => "ExecuteCommandsOnEditedMessages", 'data' => $configData["ExecuteCommandsOnEditedMessages"][0]])
					<b>Execute commands in edited messages</b>
					<br />
				</p>
				<p>
					@include("config.types.bool", ['key' => "IgnoreBots", 'data' => $configData["IgnoreBots"][0]])
					<b>Do not execute any commands issued by bots.</b>
					<br />
				</p>
				<p>
					@include("config.types.bool", ['key' => "IgnoreEveryone", 'data' => $configData["IgnoreEveryone"][0]])
					<b>Ignore <code>@everyone</code> mentions.</b> This is to prevent accidental <code>@everyone</code> mentions, it is strongly recommended to keep this enabled.
					<br />
				</p>
			</div>
			<button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse" data-target="#configAntispam" aria-expanded="false" aria-controls="configAntispam">
				Antispam
			</button>
			<div class="form-inline form-group collapse" id="configAntispam"><br />
				<p>
					Botwinder will act as configured below, if it takes any action, it will PM the naughty user letting them know about it. If you configure it to also ban for excessive spam, it will let the user know one message before banning them. Removed messages and banned users will be logged as configured in the <code>Moderation Log</code> section.
                    <br />
                    Antispam will not take any action against Admins or Moderators. You should also configure <code>Ignore Channels</code> in the Logging section - Antispam will not be active in these channels.
					<br />
					<i>Antispam will not even try to do anything if the bot does not have <code>ManageMessages</code> & <code>Ban</code> permissions.</i>
				</p>
				<p>
					Remember that you can <code>@{{ CommandCharacter }}permit @people</code> to allow anyone mentioned to post a single link or anything else in this section, for three minutes.
				</p>
				<p>
					<b>Prioritize Antispam</b>
					<br />
					@include("config.types.bool", ['key' => "PrioritizeAntispam", 'data' => $configData["PrioritizeAntispam"][0]])
					Do you want to run antispam first, before anything else? This will likely cause some false-positives sometimes, when people are legitimately using the same command a few times in a row for example (such as someone eating three cookies.)
				</p>
				<p>
					<b>Members ignore Antispam</b>
					<br />
					@include("config.types.bool", ['key' => "MembersIgnoreAntispam", 'data' => $configData["MembersIgnoreAntispam"][0]])
					Should members of roles configured on this page as <code>Member Roles</code> ignore this antispam?
					<br />
					<i>Hint - an awesome combo of different features together with this checkbox: You can configure antispam to be really harsh, use <code>Verification</code> (configured below) and have the Verified role also be a <code>Member</code> (configured in Moderation section)</i>
				</p>
				<p>
					<b>Automated ban</b>
					<br />
					If you do not want the bot to ban people for spamming, set this to <code>0</code> (zero) otherwise set a number of how many spammy messages should we tolerate before banning them. Spammy messages = links or anything else in this section below, while all the options below do have a ban option for this as well.
					<br />
					@include("config.types.int", ['key' => "SpambotBanLimit", 'data' => $configData["SpambotBanLimit"][0]])
				</p>
				<p>
					<b>Discord Invites</b>
					<br />
					@include("config.types.bool", ['key' => "RemoveDiscordInvites", 'data' => $configData["RemoveDiscordInvites"][0]])
					Remove messages that contain discord invites?
					<br />
					@include("config.types.bool", ['key' => "BanDiscordInvites", 'data' => $configData["BanDiscordInvites"][0]])
					Ban people after <code>{{ $configData["SpambotBanLimit"][0] }}</code> invites have been removed?
				</p>
				<p>
					<b>Duplicate messages</b>
					<br />
					@include("config.types.bool", ['key' => "RemoveDuplicateMessages", 'data' => $configData["RemoveDuplicateMessages"][0]])
					Remove duplicate messages? Also known as <i>literally spam</i>.
					<br />
					@include("config.types.bool", ['key' => "RemoveDuplicateCrossServerMessages", 'data' => $configData["RemoveDuplicateCrossServerMessages"][0]])
					We can also remove these cross-server. Imagine that there is someone going through many servers and posting some advertisement everywhere, but only a single message per-server so it doesn't count as standard spam. Botwinder would notice these messages as being duplicates between servers.
					<br />
					@include("config.types.bool", ['key' => "BanDuplicateMessages", 'data' => $configData["BanDuplicateMessages"][0]])
					Ban people after <code>{{ $configData["SpambotBanLimit"][0] }}</code> messages have been removed?
				</p>
				<p>
					<b>Mass-mentions</b>
					<br />
					Remove messages that mention more than <code>n</code> people? Set to <code>0</code> (zero) to disable, otherwise set the <code>n</code> amount.
					<br />
					@include("config.types.int", ['key' => "RemoveMassMentions", 'data' => $configData["RemoveMassMentions"][0]])
					<br />
					@include("config.types.bool", ['key' => "BanMassMentions", 'data' => $configData["BanMassMentions"][0]])
					Ban people after <code>{{ $configData["SpambotBanLimit"][0] }}</code> messages have been removed?
				</p>
				<p>
					<b>Mute fast-message spam</b>
					<br />
					@include("config.types.bool", ['key' => "MuteFastMessages", 'data' => $configData["MuteFastMessages"][0]])
					Temporarily mute people if they send too many messages too fast? This is done by assigning them <code>Muted Role</code>, and if they continue spamming after they get muted twice, they get banned, because that's an obvious spambot. Both, the mute and the ban are logged as configured in the <code>Logging</code> section.
					<br />
					Requires <code>Muted Role</code> to be configured in the <code>Moderation</code> section, where you can also change the duration of the mute. <i>Scroll down</i>
				</p>
				<p>
					<b>YouTube links</b>
					<br />
					@include("config.types.bool", ['key' => "RemoveYoutubeLinks", 'data' => $configData["RemoveYoutubeLinks"][0]])
					Remove YouTube links?
					<br />
					@include("config.types.bool", ['key' => "BanYoutubeLinks", 'data' => $configData["BanYoutubeLinks"][0]])
					Ban people after <code>{{ $configData["SpambotBanLimit"][0] }}</code> links have been removed?
				</p>
				<p>
					<b>Twitch links</b>
					<br />
					@include("config.types.bool", ['key' => "RemoveTwitchLinks", 'data' => $configData["RemoveTwitchLinks"][0]])
					Remove Twitch links?
					<br />
					@include("config.types.bool", ['key' => "BanTwitchLinks", 'data' => $configData["BanTwitchLinks"][0]])
					Ban people after <code>{{ $configData["SpambotBanLimit"][0] }}</code> links have been removed?
				</p>
				<p>
					<b>Hitbox/Smashcast links</b>
					<br />
					@include("config.types.bool", ['key' => "RemoveHitboxLinks", 'data' => $configData["RemoveHitboxLinks"][0]])
					Remove Hitbox and Smashcast links?
					<br />
					@include("config.types.bool", ['key' => "BanHitboxLinks", 'data' => $configData["BanHitboxLinks"][0]])
					Ban people after <code>{{ $configData["SpambotBanLimit"][0] }}</code> links have been removed?
				</p>
				<p>
					<b>Beam/Mixer links</b>
					<br />
					@include("config.types.bool", ['key' => "RemoveBeamLinks", 'data' => $configData["RemoveBeamLinks"][0]])
					Remove Beam and Mixer links?
					<br />
					@include("config.types.bool", ['key' => "BanBeamLinks", 'data' => $configData["BanBeamLinks"][0]])
					Ban people after <code>{{ $configData["SpambotBanLimit"][0] }}</code> links have been removed?
				</p>
				<p>
					<b>Imgur-like links</b>
					<br />
					@include("config.types.bool", ['key' => "RemoveImgurOrGifLinks", 'data' => $configData["RemoveImgurOrGifLinks"][0]])
					Remove imgur, gfycat, giphy or tinypic links?
					<br />
					@include("config.types.bool", ['key' => "BanImgurOrGifLinks", 'data' => $configData["BanImgurOrGifLinks"][0]])
					Ban people after <code>{{ $configData["SpambotBanLimit"][0] }}</code> links have been removed?
				</p>
				<p>
					<b>All standard links</b>
					<br />
					@include("config.types.bool", ['key' => "RemoveStandardLinks", 'data' => $configData["RemoveStandardLinks"][0]])
					Remove all standard links? This is a list of more-less standard <code>TLD</code>s to be removed, for example <code>.com</code>, <code>.net</code>, and many others... <i>(except the options above (youtube, imgur,..) - enable those if you want them removed as well.)</i>
					<br />
					@include("config.types.bool", ['key' => "BanStandardLinks", 'data' => $configData["BanStandardLinks"][0]])
					Ban people after <code>{{ $configData["SpambotBanLimit"][0] }}</code> links have been removed?
				</p>
				<p>
					<b>Extended links</b>
					<br />
					@include("config.types.bool", ['key' => "RemoveExtendedLinks", 'data' => $configData["RemoveExtendedLinks"][0]])
					Remove Extended links? Extended links are basically <code>anything.anything</code>
					<br />
					@include("config.types.bool", ['key' => "BanExtendedLinks", 'data' => $configData["BanExtendedLinks"][0]])
					Ban people after <code>{{ $configData["SpambotBanLimit"][0] }}</code> links have been removed?
				</p>
			</div>
			<button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse" data-target="#configModeration" aria-expanded="false" aria-controls="configModeration">
				Moderation
			</button>
			<div class="form-inline form-group collapse" id="configModeration"><br />
				<p>
					<b>Administrator roles</b>
					<br />
					Roles that will have Administrator permissions - refer to the documentation to see what an Admin can do.
					<br />
                    <id-selector init-form-name="RoleIDsAdmin" init-id-type="Roles"></id-selector>
				</p>
				<p>
					<b>Moderator roles</b>
					<br />
					Roles that will have Moderator permissions - refer to the documentation to see what a Moderator can do.
					<br />
                    <id-selector init-form-name="RoleIDsModerator" init-id-type="Roles"></id-selector>
				</p>
				<p>
					<b>SubModerator roles</b>
					<br />
					Roles that will have SubModerator permissions - refer to the documentation to see what a SubModerator can do.
					<br />
                    <id-selector init-form-name="RoleIDsSubModerator" init-id-type="Roles"></id-selector>
				</p>
				<p>
					<b>Member roles</b>
					<br />
					Moderators will be able to <code>@{{ CommandCharacter }}promote</code> and <code>@{{ CommandCharacter }}demote</code> people into these Member roles.
					<br />
                    <id-selector init-form-name="RoleIDsMember" init-id-type="Roles"></id-selector>
				</p>
				<p>
					@include("config.types.bool", ['key' => "RemovePromote", 'data' => $configData["RemovePromote"][0]])
					Remove all uses of <code>@{{ CommandCharacter }}promote</code>/<code>@{{ CommandCharacter }}demote</code> commands from the chat.
				</p>
				<p>
					<b>Public roles</b>
					<br />
					These roles are public, and anyone can <code>@{{ CommandCharacter }}join</code> or <code>@{{ CommandCharacter }}leave</code> them.
					<br />
                    <id-selector init-form-name="PublicRoleIDs" init-id-type="Roles"></id-selector>
				</p>
				<p>
					@include("config.types.bool", ['key' => "RemoveJoin", 'data' => $configData["RemoveJoin"][0]])
					Remove all uses of <code>@{{ CommandCharacter }}join</code>/<code>@{{ CommandCharacter }}leave</code> commands from the chat.
				</p>
				<p>
					<b>!op</b>
					<br />
					This feature will act like Operators known from IRC. If configured, it will disable the use of ban/kick/mute commands unless <i>you</i> are <code>@{{ CommandCharacter }}op</code>-ed (you can still use quickban, if configured, because it's quick!) This helps making it clear to the user, that <i>you</i> are now a acting as a moderator and you are not just joking around. Set the Operator role below to enable it, or use <code>0</code> (zero) to disable.
					<br /><br />
					<b>Operator</b> role. Hint: You can configure this role to have nice vibrant colour, to send a clear message to everyone that a moderator is there.
					<br />
                    <type-selector init-id-type="RoleIDOperator" label="name" :default-value='{{ json_encode($guild['roles']->get($configData["RoleIDOperator"][0])) }}' :values='roles'></type-selector>
				</p>
				<p>
					<b>Quickban</b>
					<br />
					Should you wish to use the <code>@{{ CommandCharacter }}quickban</code> you have to configure the reason why are you banning the user. This will be PMed them just like with standard <code>@{{ CommandCharacter }}ban</code>. We recommend something like <code>Ignoring the rules / spamming inappropriate content.</code> (The command will be disabled if you leave this field empty.)
					<br />
					@include("config.types.multi-line-text", ['key' => "QuickbanReason", 'data' => $configData["QuickbanReason"][0]])
					<br /><br />
					And for how long do you want to ban them using this command? Set <code>0</code> (zero) for permanent ban.
					<br />
					@include("config.types.int", ['key' => "QuickbanDuration", 'data' => $configData["QuickbanDuration"][0]]) (hours)
				</p>
				<p>
					<b>Mute</b>
					<br />
					Duration of the <code>@{{ CommandCharacter }}mute @user</code> and <code>@{{ CommandCharacter }}muteChannel</code> commands (This is hard-capped between 5 and 60 minutes.)
					<br />
					@include("config.types.int", ['key' => "MuteDuration", 'data' => $configData["MuteDuration"][0]]) (minutes)
					<br /><br />
					<code>Muted Role</code> - Role that will be used for the purpose of muting people, this role will be configured by Botwinder to prevent people from talking in all your channels.
					<br />
					<type-selector init-id-type="MuteRole" label="name" :default-value='{{ json_encode($guild['roles']->get($configData["MuteRole"][0])) }}' :values='roles'></type-selector>
					<br /><br />
					The above role will not be configured in the following channel, allowing you to talk to muted people in it.
					<br />
                    <type-selector init-id-type="MuteIgnoreChannel" label="name" :default-value='{{ json_encode($guild['channels']->get($configData["MuteIgnoreChannel"][0])) }}' :values='channels'></type-selector>
					<br />
                    Example usage of this <i>chill-zone</i> channel: <a href="/img/mute.gif" target="_blank">gif</a> which can be configured with <a href="/img/mute-permissions.gif" target="_blank">these permissions</a>.
                    <br /><br />
                    <b>How does the Mute system work</b>
                    <br />
                    It is important that you understand how does the Muting system work:<br />
                    Regardless of how is the user muted, they get unmuted next time the bot restarts, this is to ensure that nobody is left hanging, because it is supposed to be a timed feature.
                    Now if someone leaves and then rejoins the server, they will be Muted again, and this time it is treated as an antispam mute, which means that the third one will get you banned. So cheating to get rid of the "mute" role is really bad idea and if the <i>victim</i> leaves and joins the server twice while they are muted, they get banned.
				</p>
				<p>
                    <b><a href="http://rhea-ayase.eu/articles/2017-04/Moderation-guidelines" target="_blank">Moderation Guidelines</a></b>
                    <br />
                    Moderation guidelines for inclusive community. <i>(Written by Rhea.)</i>
                    <br />
                    <b><a href="http://rhea-ayase.eu/articles/2016-11/On-the-topic-of-moderation" target="_blank">On the topic of Moderation</a></b>
                    <br />
                    Another article about moderating a community, full of Discord/Botwinder examples. <i>(Written by Rhea.)</i>
				</p>
			</div>
			<button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse" data-target="#configLogging" aria-expanded="false" aria-controls="configLogging">
				Logging
			</button>
			<div class="form-inline form-group collapse" id="configLogging"><br />
				<p><br />
					<b>Mod channel</b>
					<br /><br />
					@include("config.types.bool", ['key' => "ModChannelLogBans", 'data' => $configData["ModChannelLogBans"][0]])
					Log banned and kicked users into the following channel, if you don't set one, the other below mentioned channel will be used.
					<br />
                    <type-selector init-id-type="ModChannelBans" label="name" :default-value='{{ json_encode($guild['channels']->get($configData["ModChannelBans"][0])) }}' :values='channels'></type-selector>
					<br /><br />
					In which channel would you like to log the below configured events?
					<br />
                    <type-selector init-id-type="ModChannel" label="name" :default-value='{{ json_encode($guild['channels']->get($configData["ModChannel"][0])) }}' :values='channels'></type-selector>
					<br /><br />
					@include("config.types.bool", ['key' => "ModChannelLogEditedMessages", 'data' => $configData["ModChannelLogEditedMessages"][0]])
					Log edited messages.
					<br />
					@include("config.types.bool", ['key' => "ModChannelLogDeletedMessages", 'data' => $configData["ModChannelLogDeletedMessages"][0]])
					Log deleted messages.
					<br />
					@include("config.types.bool", ['key' => "ModChannelLogAntispam", 'data' => $configData["ModChannelLogAntispam"][0]])
					Log messages deleted by Antispam.
					<br />
					@include("config.types.bool", ['key' => "ModChannelLogMembers", 'data' => $configData["ModChannelLogMembers"][0]])
					Log the use of the <code>@{{ CommandCharacter }}join</code> and <code>@{{ CommandCharacter }}leave</code> commands, as well as the <code>@{{ CommandCharacter }}promote</code> & <code>@{{ CommandCharacter }}demote</code>.
					<br /><br />
					Ignore channels in this list - messages deleted or edited in these channels will not be logged.
					<br />
                    <id-selector init-form-name="ModChannelIgnore" init-id-type="Channels"></id-selector>
					<br /><br />
					Ignore people/bots in this list - messages by these users will not be logged. (User ID - use <a href="/img/devMode.png" target="_blank">dev mode</a> -> rightclick)
					<br />
                    <custom-input-list title="Ignore users" form-name="ModChannelIgnoreUsers" :init-values="{{ json_encode($configData["ModChannelIgnoreUsers"][0]) }}"></custom-input-list>
				</p><br />
				<p>
					<b>User Activity channel</b>
					<br /><br />
					In which channel would you like to log the below configured events?
					<br />
                    <type-selector init-id-type="UserActivityChannel" label="name" :default-value='{{ json_encode($guild['channels']->get($configData["UserActivityChannel"][0])) }}' :values='channels'></type-selector>
					<br />
					@include("config.types.bool", ['key' => "UserActivityLogTimestamp", 'data' => $configData["UserActivityLogTimestamp"][0]])
					Include a Timestamp.
					<br /><br />
					@include("config.types.bool", ['key' => "UserActivityLogJoined", 'data' => $configData["UserActivityLogJoined"][0]])
					Display the following message when a new user joins your server. Use <code>{0}</code> in the message where their username should be.
					<br />
					@include("config.types.multi-line-text", ['key' => "UserActivityMessageJoined", 'data' => $configData["UserActivityMessageJoined"][0]])
					<br />
					@include("config.types.bool", ['key' => "UserActivityMention", 'data' => $configData["UserActivityMention"][0]])
					Mention these people? (Will use only their username if this is <code>false</code>)
					<br /><br />
					@include("config.types.bool", ['key' => "UserActivityLogLeft", 'data' => $configData["UserActivityLogLeft"][0]])
					Display the following message when someone leaves your server. Use <code>{0}</code> in the message where their username should be.
					<br />
					@include("config.types.multi-line-text", ['key' => "UserActivityMessageLeft", 'data' => $configData["UserActivityMessageLeft"][0]])
					<br />
					@include("config.types.bool", ['key' => "UserActivityMentionLeft", 'data' => $configData["UserActivityMentionLeft"][0]])
					Mention these people? (Will use only their username if this is <code>false</code>)
				</p>
			</div>
			<button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse" data-target="#configNewUser" aria-expanded="false" aria-controls="configNewUser">
				New User / Verification
			</button>
			<div class="form-inline form-group collapse" id="configNewUser"><br />
				<p><br />
					<b>New User</b>
					<br /><br />
					@include("config.types.bool", ['key' => "WelcomeMessageEnabled", 'data' => $configData["WelcomeMessageEnabled"][0]])
					PM the following message to the user, when they join your server. Use <code>{0}</code> in the message where their username should be.
					<br />
					@include("config.types.multi-line-text", ['key' => "WelcomeMessage", 'data' => $configData["WelcomeMessage"][0]])
					<br /><br />
					Assign them the following role.
					<br />
                    <type-selector init-id-type="WelcomeRoleID" label="name" :default-value='{{ json_encode($guild['roles']->get($configData["WelcomeRoleID"][0])) }}' :values='roles'></type-selector>
				</p><br />
				<p>
					<b>Verification systems</b>
					<br /><br />
                    How does this work... The bot will send information how to get verified to the user, they follow the steps and at the end receive Verified Role. We recommend to give this role normal permissions, while the <code>@everyone</code> role should have just basic read permissions and be unable to speak, upload files, etc...
					<br /><br />
                    <b>Reddit Verification</b>
                    <br />
                    The bot will ask the user to send a message via Reddit, and after receiving it with the right codes, it will assign them the Verified Role.
                    <br /><br />
                    <b>Code Verification</b>
                    <br />
                    The bot will PM the user your rules (configured below) with hidden code within, in order to force the user to read them. They have to find the code, and send it back, to be assigned the Verified Role.
                    <br /><br />
					@include("config.types.bool", ['key' => "VerifyEnabled", 'data' => $configData["VerifyEnabled"][0]])
					Enable verification system.
                    <br />
                    Assign the following role to verified users.
					<br />
                    <type-selector init-id-type="VerifyRoleID" label="name" :default-value='{{ json_encode($guild['roles']->get($configData["VerifyRoleID"][0])) }}' :values='roles'></type-selector>
                    <br />
                    (Recommended permissions: <a href="/img/verifyRole.png" target="_blank">Verified Role</a> and <a href="/img/verifyEveryone.png" target="_blank">@everyone</a>)
					<br /><br />
					@include("config.types.bool", ['key' => "VerifyUseReddit", 'data' => $configData["VerifyUseReddit"][0]])
					Use Reddit message to verify people? (Set this to <code>false</code> to use "Code Verification.")
					<br /><br />
					This message will be included in the instructions PMed to the user. If you are using Reddit, you can just list the benefits (extra permissions) of the verification, or in case of the Code Verification, we recommend using well crafted rules, such as the ones in the <a href="http://rhea-ayase.eu/articles/2017-04/Moderation-guidelines" target="_blank">Moderation Guidelines</a> written by Rhea.
					<br />
					@include("config.types.multi-line-text", ['key' => "VerifyPM", 'data' => $configData["VerifyPM"][0]])
					<br /><br />
					@include("config.types.bool", ['key' => "VerifyOnWelcome", 'data' => $configData["VerifyOnWelcome"][0]])
					Send the verification info to the user, as soon as they join the server. You can also send it to them using <code>@{{ CommandCharacter }}verify @user</code> or they can request it be sent with <code>@{{ CommandCharacter }}verify</code> without parameters.
					<br /><br />
					How many {{ $configData["KarmaCurrency"][0] }} do you want to give them? Use <code>0</code> (zero) to disable. This also depends on whether your karma system is enabled or not.
					<br />
					@include("config.types.int", ['key' => "VerifyKarma", 'data' => $configData["VerifyKarma"][0]])
					<br /><br />
					If you happen to have a user who does not have Reddit account or for some reason can't use our system, you can manually verify them with any other link to any social network, email, or simply use the <code>force</code> keyword to forcefully verify them. Examples follow:
					<br />
					<code>@{{ CommandCharacter }}verify @Rhea https://www.reddit.com/user/RheaAyase</code>
					<br />
					<code>@{{ CommandCharacter }}verify @Rhea rhea@botwinder.info</code>
					<br />
					<code>@{{ CommandCharacter }}verify @Rhea force</code>
				</p>
			</div>
			<button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse" data-target="#configSocial" aria-expanded="false" aria-controls="configSocial">
				Social commands
			</button>
			<div class="form-inline form-group collapse" id="configSocial"><br />
				<p>
					<b>Karma system</b>
                    <br />
                    Karma is an extra appreciation of helpful people. They get thanked, they get a cookie!
                    <br /><code>Rhea: Hey thanks for that pull request fixing a typo @freiheit</code>
                    <br /><code>Botwinder: @freiheit received a <i>thank you</i> cookie!</code>
                    <br />You can also `!give @user` a cookie, however, this will take one of yours. You can eat them as well. Many details can be customized below...
					<br />
					@include("config.types.bool", ['key' => "KarmaEnabled", 'data' => $configData["KarmaEnabled"][0]])
					Use Karma system?
					<br /><br />
					Currency plural (Definitely cookies!)
					<br />
					@include("config.types.text", ['key' => "KarmaCurrency", 'data' => $configData["KarmaCurrency"][0]]) (This is also a command to check your <i>{{ $configData["KarmaCurrency"][0] }}</i>)
					<br />
					Currency singular
					<br />
					@include("config.types.text", ['key' => "KarmaCurrencySingular", 'data' => $configData["KarmaCurrencySingular"][0]])
					<br /><br />
					Consume command - eating a cookie is selfish act and will effectively reduce the number you have by one.
					<br />
					@include("config.types.text", ['key' => "KarmaConsumeCommand", 'data' => $configData["KarmaConsumeCommand"][0]])
					<br />
					Consume verb used in response to the above command. Past tense please.
					<br />
					@include("config.types.text", ['key' => "KarmaConsumeVerb", 'data' => $configData["KarmaConsumeVerb"][0]])
					<br /><br />
					How many people can be mentioned at the same time, to give them <i>cookies</i>?
					<br />
					@include("config.types.int", ['key' => "KarmaLimitMentions", 'data' => $configData["KarmaLimitMentions"][0]])
					<br />
					How often can someone <i>thank</i> others to give them <i>cookies</i>? (Consider this number a thankyou-cooldown in minutes.)
					<br />
					@include("config.types.int", ['key' => "KarmaLimitMinutes", 'data' => $configData["KarmaLimitMinutes"][0]])
					<br />
					@include("config.types.bool", ['key' => "KarmaLimitResponse", 'data' => $configData["KarmaLimitResponse"][0]])
					Tell people if they exceed this limit?
				</p><br />
			</div>
			<button class="btn btn-fading btn-full-width" type="button" data-toggle="collapse" data-target="#customCommands" aria-expanded="false" aria-controls="customCommands">
				Custom Commands
			</button>
			<div class="form-group collapse" id="customCommands">
				<p>
					<custom-commands form-name="CustomCommands"></custom-commands>
				</p>
			</div>

			{{ csrf_field() }}
			<button class="btn btn-primary" type="button" :disabled="anyLoading" @click="onSubmit">Save</button>
		</form>
	</div>
</div>
@endsection
