<template>
    <div>
        <p>
            <vuex-switch store-name="memo_enabled">
                <b>Enable <code>{{ command_prefix }}memo</code></b>
            </vuex-switch>
        </p>
        <p>
            <vuex-switch store-name="profile_enabled">
                <b>Enable profiles</b>
            </vuex-switch>
            <a href="/img/profiles.png">See profiles in action here.</a>
            <br>
            Setup profile fields in the editor below.
            <br>
            <profile-editor />
        </p>
        <p>
            <b>Activity Member role</b>
            <br>Some servers prefer to (mis)use experience system to merely assign a member role after user shows some activity - sends a few messages. Please consider using the above verification system, and if that is not what you're after, use this instead of the experience system.
            <br>Member role to be assigned:
            <br>
            <vuex-multiselect
                store-name="exp_member_roleid"
                option-name="roles"/>
            <br><br>
            Number of messages a user has to send to get the above Member role (<i>Leave this at zero to disable it.</i>)
            <vuex-number store-name="exp_member_messages" />
        </p>
        <p>
            <b>Experience & levels</b>
            <br>Users earn experience based on the below configuration and they are granted levels, which may or may not have roles associated with them.
            <br>Take a look at the <a href="https://docs.google.com/spreadsheets/d/2w-eZn3b8FgjQkM6FS1q6q5XU6epvbJbmH74IMgRUke4">progression table</a>.
            <br><i>(Please don't enter stupid (high) numbers, you will only break it on your end.)</i>
            <br><br>
            <vuex-switch store-name="exp_enabled">
                <b>Experience Enabled</b>
            </vuex-switch>
            <br>
            <vuex-switch store-name="exp_announce_levelup">
                Announce level-up
            </vuex-switch>
            <br>
            Base experience value (<code>baseExp</code>) <i>Higher value means slower progression, default <code>10</code></i>.
            <vuex-number store-name="base_exp_to_levelup" />
            <br><br>
            Experience given per message (<code>expPerMessage</code>) <i>Higher value means faster progression, default <code>1</code></i>.
            <vuex-number store-name="exp_per_message" />
            <br><br>
            Experience given per image (attachment) (<code>expPerImage</code>) <i>Higher value means faster progression, default <code>3</code></i>.
            <vuex-number store-name="exp_per_attachment" />
            <br><br>
            Maximum level - set to <code>0</code> (zero) to disable.
            <vuex-number store-name="exp_max_level" />
            <br><br>
            Roles at levels
            <br>
            <level-selector />
            <vuex-switch store-name="exp_cumulative_roles">
                Are these roles cumulative? (<code>true</code> - all the roles are assigned for all the previous levels; <code>false</code> - only one role will be assigned and the previous level roles will be removed.)
            </vuex-switch>
            <br>
            <vuex-switch store-name="exp_advance_users">
                Valkyrja can advance users to the above configured highest role. This means that if a user already has a higher level role, than their level, their level will be increased to match the role. This is useful if you are transitioning from other level systems, this way your users won't lose their progress!
            </vuex-switch>
            <br>
            How many {{ karma_currency }} do you want to give them every level-up? (this will scale up for higher levels.) Use <code>0</code> (zero) to disable. This also depends on whether your karma system is enabled or not.
            <vuex-number store-name="karma_per_level" />
        </p>
        <article class="message is-info">
            <div class="message-header">
                <p>Karma system</p>
            </div>
            <div class="message-body">
                Karma is an extra appreciation of helpful people. They get thanked, they get a cookie!
                <br><code>Rhea: Hey thanks for that pull request fixing a typo @freiheit</code>
                <br><code>Valkyrja: @freiheit received a <i>thank you</i> cookie!</code>
                <br>You can also <code>!give @user</code> a cookie, however, this will take one of yours. You can eat them as well. Many details can be customized below...
                <br><i>Hint: Create <code>{{ command_prefix }}alias</code> for the <code>cookies</code> and <code>nom</code> commands to fit your custom configuration below!</i>
            </div>
        </article>
        <p>
            <vuex-switch store-name="karma_enabled">
                Use Karma system?
            </vuex-switch>
            <br>
            Currency plural (Definitely cookies!)
            <vuex-text store-name="karma_currency" />
            <br><br>
            Currency singular
            <vuex-text store-name="karma_currency_singular" />
            <br><br>
            If you've changed the consume command <code>nom</code> by creating an alias, please specify it here. <i>(Eating a cookie is selfish act and will effectively reduce the number you have by one.)</i>
            <vuex-text store-name="karma_consume_command" />
            <br><br>
            Consume verb used in response to the <code>{{ command_prefix }}nom</code> command. Past tense please.
            <vuex-text store-name="karma_consume_verb" />
            <br><br>
            How many people can be mentioned at the same time, to give them <i>cookies</i>?
            <vuex-number store-name="karma_limit_mentions" />
            <br><br>
            How often can someone <i>thank</i> others to give them <i>cookies</i>? (Consider this number a thankyou-cooldown in minutes.)
            <vuex-number store-name="karma_limit_minutes" />
            <br><br>
            <vuex-switch store-name="karma_limit_response">
                Tell people if they exceed this limit?
            </vuex-switch>
        </p>
    </div>
</template>

<script>
import VuexSwitch from "../../Vuex/VuexSwitch";
import VuexText from "../../Vuex/VuexText";
import VuexNumber from "../../Vuex/VuexNumber";
import VuexMultiselect from "../../Vuex/VuexMultiselect";
import VuexTextarea from "../../Vuex/VuexTextarea";
import ProfileEditor from "./ProfileEditor/ProfileEditor";
import LevelSelector from "./LevelSelector/LevelSelector";

export default {
    name: "SocialConfig",
    components: {
        VuexSwitch,
        VuexText,
        VuexNumber,
        VuexMultiselect,
        ProfileEditor,
        LevelSelector,
    },
    computed: {
        command_prefix() {
            return this.config("command_prefix");
        },
        karma_currency() {
            return this.config("karma_currency");
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
