<template>
    <div>
        <p>
            <b>Moderation Log Channel</b> - In which channel would you like to log the below configured events?
            <br>
            <vuex-multiselect
                store-name="mod_channelid"
                option-name="channels"
                item-icon="pound"/>
            <br>
            <vuex-switch store-name="embed_modchannel">
                Use Embed with below configured colours
            </vuex-switch>
            <vuex-switch store-name="log_bans">
                Log muted, kicked and banned users
            </vuex-switch>
            <vuex-color store-name="color_modchannel"/>
            <br><br>
            <vuex-switch store-name="log_warnings">
                Log warnings (<code>{{ command_prefix }}addWarning</code> and <code>{{ command_prefix }}issueWarning</code> commands)
            </vuex-switch>
            <vuex-color store-name="color_logwarning"/>
            <br><br>
            <b>Log Channel</b> - In which channel would you like to log the below configured events?
            <br>
            <vuex-multiselect
                store-name="log_channelid"
                option-name="channels"
                item-icon="pound"/>
            <br>
            <vuex-switch store-name="embed_logchannel">
                Use Embed with below configured colours
            </vuex-switch>
            <vuex-switch store-name="log_editedmessages">
                Log edited messages.
            </vuex-switch>
            <vuex-switch store-name="log_deletedmessages">
                Log deleted messages.
            </vuex-switch>
            <br>
            <vuex-color store-name="color_logmessages"/>
            <br><br>
            <vuex-switch store-name="log_promotions">
                Log the use of the <code>{{ command_prefix }}join</code> and <code>{{ command_prefix }}leave</code> commands, as well as the <code>{{ command_prefix }}promote</code> & <code>{{ command_prefix }}demote</code>.
            </vuex-switch>
            <br>
            <vuex-color store-name="color_logchannel"/>
            <br><br>
            <b>Voice Activity Log Channel</b> - logs users joining and leaving voice channels.
            <br>
            <vuex-multiselect
                store-name="voice_channelid"
                option-name="channels"
                item-icon="pound"/>
            <br>
            <vuex-switch store-name="embed_voicechannel">
                Use Embed with this colour:
            </vuex-switch>
            <vuex-color store-name="color_voicechannel"/>
            <br>
        </p>
        <p>
            <b>User Activity log channel</b> - In which channel would you like to log the below configured
            events?
            <br>
            <vuex-multiselect
                store-name="activity_channelid"
                option-name="channels"
                item-icon="pound"/>
            <br>
            <vuex-switch store-name="embed_activitychannel">
                Use Embed with this colour:
            </vuex-switch>
            <vuex-color store-name="color_activitychannel"/>
            <br><br>
            <vuex-switch store-name="log_join">
                Display the following message when a new user joins your server. Use <code>{0}</code> in the message where their username should be. <i>(Message has to be shorter than 200 characters for embeds to work.)</i>
            </vuex-switch>
            <vuex-textarea store-name="log_message_join"/>
            <br>
            <vuex-switch store-name="log_mention_join">
                Mention these people? (Will use only their username if this is <code>false</code>)
            </vuex-switch>
            <vuex-switch store-name="log_timestamp_join">
                Display timestamp.
            </vuex-switch>
            <br>
            <vuex-switch store-name="log_leave">
                Display the following message when someone leaves your server. Use <code>{0}</code> in the message where their username should be. <i>(Message has to be shorter than 200 characters for embeds to work.)</i>
            </vuex-switch>
            <vuex-textarea store-name="log_message_leave"/>
            <br>
            <vuex-switch store-name="log_mention_leave">
                Mention these people? (Will use only their username if this is <code>false</code>)
            </vuex-switch>
            <vuex-switch store-name="log_timestamp_leave">
                Display timestamp.
            </vuex-switch>
            <br>
            <b>Ignore channels</b> - messages deleted or edited in these channels will not be logged.
            <br>
            <ignored-channels />
        </p>
    </div>
</template>

<script>
import VuexMultiselect from "../../Vuex/VuexMultiselect";
import VuexSwitch from "../../Vuex/VuexSwitch";
import VuexTextarea from "../../Vuex/VuexTextarea";
import VuexColor from "../../Vuex/VuexColor";
import IgnoredChannels from "./IgnoredChannels/IgnoredChannels";

export default {
    name: "LoggingConfig",
    components: {
        VuexMultiselect,
        VuexSwitch,
        VuexTextarea,
        VuexColor,
        IgnoredChannels,
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
