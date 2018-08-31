<template>
    <div>
        <p>
            <b>Permissions</b>
            <br>
            Botwinder expects server and channel permissions to be correct and some functions may not work if you do not pay enough attention to this topic.
            <br>
            First permissions of the bot - you have to not only give it the permissions but also <a 
                href="http://i.imgur.com/T8MPvME.png" 
                target="_blank">to move it up in the <u>roles hierarchy</u></a>. The bot can only assign roles to, and kick or ban users that are below his own role.
            <br>
            Second common mistake is wallpapering (to some degree) channel permissions. This may prevent the bot from talking - executing commands, this may also block it from correctly handling channel or user mute, etc. Read <a 
                href="http://rhea-ayase.eu/articles/2016-12/Discord-Guide-Server-setup-and-permissions" 
                target="_blank">this guide about permissions</a>.
        </p>
        <p>
            <b>Command Prefix</b> - required option, do not leave this empty!<br>
            <vuex-text store-name="command_prefix"/>
        </p>
        <p>
            <b>Alternative Command Prefix</b> - will be used as well as the above, you can leave this one empty.
            <br>
            <vuex-text store-name="command_prefix_alt"/>
        </p>
        <p>
            <vuex-switch store-name="execute_on_edit">
                <b>Execute commands in edited messages</b>
            </vuex-switch>
        </p>
        <p>
            <vuex-switch store-name="ignore_bots">
                <b>Do not execute any commands issued by bots.</b>
            </vuex-switch>
        </p>
        <p>
            <vuex-switch store-name="ignore_everyone">
                <b>Ignore <code>@everyone</code> mentions.</b> This is to prevent accidental <code>@everyone</code> mentions, it is strongly recommended to keep this enabled.
            </vuex-switch>
        </p>
    </div>
</template>

<script>
import VuexSwitch from "../../Vuex/VuexSwitch";
import VuexText from "../../Vuex/VuexText";
export default {
    name: "BasicConfig",
    components: {
        VuexSwitch,
        VuexText
    }
};
</script>

<style scoped>

</style>