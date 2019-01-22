<template>
    <div class="panel">
        <div class="panel-heading">
            Selected Message
        </div>
        <div class="panel-block">
            <div class="control field">
                <div class="control is-expanded">
                    <input
                        id="reaction_id"
                        :disabled="disabled"
                        v-model="messageId"
                        placeholder="Message ID"
                        type="text"
                        class="input">
                </div>
                <label
                    for="reaction_id"
                    class="help">
                    ID of a message where to watch for reactions. (Use DevMode enabled in the settings of Discord client, right-click a message and <code>copy ID</code>.)
                </label>
            </div>
        </div>
        <div class="panel-block is-paddingless">
            <reaction-roles-emoji v-if="!disabled"/>
        </div>
    </div>
</template>

<script>
import ReactionRolesEmoji from "./ReactionRolesEmoji";

export default {
    name: "ReactionRolesForm",
    components: {
        ReactionRolesEmoji,
    },
    props: {
        disabled: {
            type: Boolean,
            default: false,
            required: false,
        },
    },
    computed: {
        state() {
            return this.$store.state.reactionRoles;
        },
        messageId: {
            get() {
                return this.state.selectedRole;
            },
            set(id) {
                this.$store.dispatch("reactionRoles/changeField", {
                    field: "messageId",
                    value: id
                });
            },
        }
    },
};
</script>

