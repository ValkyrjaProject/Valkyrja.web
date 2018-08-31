<template>
    <div>
        <p>
            <b>Roles</b>
            <br>
            Roles that will have different kind of permissions - refer to the documentation to see what can each permission do. (You can also customize that using the <code>{{ command_prefix }}permissions</code> command.)
            <br>
            Public Roles default to <code>No group</code> where any user can <code>{{ command_prefix }}join</code> any of these roles. Any other public role group will be exclusive, and the user can have only one role out of a group at the time. You can have multiple groups.
            <br>
            <role-selector/>
        </p>
        <p>
            <b>!op</b>
            <br>
            This feature will act like Operators known from IRC. If configured, it will disable the use of ban/kick/mute commands unless <i>you</i> are <code>{{ command_prefix }}op</code>-ed (you can still use quickban, if configured, because it's quick!) This helps making it clear to the user, that <i>you</i> are now a acting as a moderator and you are not just joking around. Set the Operator role below to enable it.
            <br><br>
            <b>Operator</b> role. Hint: You can configure this role to have nice vibrant colour, to send a
            clear message to everyone that a moderator is there.
            <br>
            <type-selector
                :default-value="{{ json_encode($guild["
                init-id-type="operator_roleid"
                label="name"
                roles']->get(old('operator_roleid', $serverConfig["operator_roleid"]))) }}'
                :values='roles'></type-selector>
        </p>
        <p>
            <b>Quickban</b>
            <br>
            Should you wish to use the <code>{{ command_prefix }}quickban</code> you have to configure the reason why are you banning the user. This will be PMed them just like with standard <code>@{{ command_prefix }}ban</code>. We recommend something like <code>Ignoring the rules / spamming inappropriate content.</code> (The command will be disabled if you leave this field empty.)
            <br>
            @include("config.types.multi-line-text", ['key' => "quickban_reason", 'data' => old('quickban_reason', $serverConfig["quickban_reason"])])
            <br><br>
            And for how long do you want to ban them using this command? Set <code>0</code> (zero) for
            permanent ban.
            <br>
            @include("config.types.int", ['key' => "quickban_duration", 'data' => old('quickban_duration', $serverConfig["quickban_duration"])])
            (hours)
            <vuex-number
                :min="0"
                store-name="quickban_duration">(hours)</vuex-number>
        </p>
        <p>
            <code>Muted Role</code> - Role that will be used for the purpose of muting people, this role
            will be configured by Botwinder to prevent people from talking in all your channels.
            <br>
            <type-selector
                :default-value="{{ json_encode($guild["
                init-id-type="mute_roleid"
                label="name"
                roles']->get(old('mute_roleid',$serverConfig["mute_roleid"]))) }}'
                :values='roles'></type-selector>
            <br><br>
            The above role will not be configured in the following channel, allowing you to talk to muted
            people in it.
            <br>
            <type-selector
                :default-value="{{ json_encode($guild["
                init-id-type="mute_ignore_channelid"
                label="name"
                channels']->get(old('mute_ignore_channelid', $serverConfig["mute_ignore_channelid"]))) }}'
                :values='channels'></type-selector>
            <br>
            Example usage of this <i>chill-zone</i> channel: <a
                href="/img/mute.gif"
                target="_blank">gif</a>
            which can be configured with <a
                href="/img/mute-permissions.gif"
                target="_blank">these
            permissions</a>.
            <br><br>
            <b>How does the Mute system work</b>
            <br>
            It is important that you understand how does the Muting system work:<br> Regardless of how is the user muted, they get unmuted next time the bot restarts, this is to ensure that nobody is left hanging, because it is supposed to be a timed feature. Now if someone leaves and then rejoins the server, they will be Muted again, and this time it is treated as an antispam mute, which means that the third one will get you banned. So cheating to get rid of the "mute" role is really bad idea and if the <i>victim</i> leaves and joins the server twice while they are muted, they get banned.
        </p>
        <p>
            <b><a
                href="http://rhea-ayase.eu/articles/2017-04/Moderation-guidelines"
                target="_blank">Moderation
                Guidelines</a></b>
            <br>
            Moderation guidelines for inclusive community. <i>(Written by Rhea.)</i>
            <br>
            <b><a
                href="http://rhea-ayase.eu/articles/2016-11/On-the-topic-of-moderation"
                target="_blank">On
                the topic of Moderation</a></b>
            <br>
            Another article about moderating a community, full of Discord/Botwinder examples. <i>(Written by
            Rhea.)</i>
        </p>
    </div>
</template>

<script>
import RoleSelector from "./RoleSelector/RoleSelector";
import VuexNumber from "../../Vuex/VuexNumber";

export default {
    name: "ModerationConfig",
    components: {
        RoleSelector,
        VuexNumber
    },
    computed: {
        command_prefix() {
            return this.config("command_prefix");
        }
    },
    methods: {
        config(name) {
            return this.$store.getters.configInput(name).toString();
        }
    }
};
</script>

<style scoped>

</style>
