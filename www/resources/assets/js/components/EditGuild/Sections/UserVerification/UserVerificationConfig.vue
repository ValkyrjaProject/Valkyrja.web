<template>
    <div>
        <p>
            <b>New User</b>
            <vuex-switch store-name="welcome_pm">
                PM the following message to the user, when they join your server. Use <code>{0}</code> in the message where their username should be.
            </vuex-switch>
            <vuex-textarea store-name="welcome_message"/>
            <br>
            Assign them the following role.
            <vuex-multiselect
                store-name="welcome_roleid"
                option-name="roles"/>
        </p>
        <p>
            <b>Code Verification</b>
            <br>
            The bot will send information how to get verified to the user via PM together with your rules (configured below) and a hidden code within the text. They will be assigned Verified Role after they find the code and reply with it back to the bot. We recommend to give this role normal permissions, while the <code>@everyone</code> role should have just basic read permissions and be unable to speak, upload files, etc...
            <br>
            <vuex-switch store-name="verify">
                Enable verification system.
            </vuex-switch>
            <br>
            Assign the following role to verified users.
            <vuex-multiselect
                store-name="verify_roleid"
                option-name="roles"/>
            (Recommended permissions: <a
                href="/img/verifyRole.png"
                target="_blank">Verified Role</a> and <a
                    href="/img/verifyEveryone.png"
                    target="_blank">@everyone</a>)
            <br><br>
            This message will be included in the instructions PMed to the user. If you are using Reddit, you can just list the benefits (extra permissions) of the verification, or in case of the Code Verification, we recommend using well crafted rules, such as the ones in the <a
                href="http://rhea-ayase.eu/articles/2017-04/Moderation-guidelines"
                target="_blank">Moderation Guidelines</a> written by Rhea.
            <vuex-textarea store-name="verify_message"/>
            <br>
            <vuex-switch store-name="verify_on_welcome">
                Send the verification info to the user, as soon as they join the server. You can also send it to them using <code>{{ command_prefix }}verify @user</code> or they can request it be sent with <code>{{ command_prefix }}verify</code> without parameters.
            </vuex-switch>
            <br><br>
            How many {{ karma_currency }} do you want to give them? Use <code>0</code> (zero) to disable. This also depends on whether your karma system is enabled or not.
            <vuex-number store-name="verify_karma"/>
            <br>
            If you need to verify someone manually, you can use the verify command with <code>force</code> parameter, such as this:
            <br>
            <code>{{ command_prefix }}verify @Rhea force</code>
        </p>
    </div>
</template>

<script>
import VuexSwitch from "../../Vuex/VuexSwitch";
import VuexText from "../../Vuex/VuexText";
import VuexNumber from "../../Vuex/VuexNumber";
import VuexMultiselect from "../../Vuex/VuexMultiselect";
import VuexTextarea from "../../Vuex/VuexTextarea";

export default {
    name: "UserVerificationConfig",
    components: {
        VuexSwitch,
        VuexText,
        VuexNumber,
        VuexMultiselect,
        VuexTextarea,
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
