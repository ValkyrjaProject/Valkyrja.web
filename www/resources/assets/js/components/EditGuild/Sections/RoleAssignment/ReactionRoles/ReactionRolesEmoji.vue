<template>
    <div class="columns is-desktop is-root is-gapless">
        <div class="columns column is-marginless is-gapless">
            <panel-list
                v-model="availableRoles"
                :remove-radius="true"
                title="Available Roles"
                class="column is-half" />
            <panel-list
                v-model="addedRoles"
                :remove-radius="true"
                title="Added Roles"
                class="column is-half is-radiusless" />
        </div>
        <div
            class="column is-one-third is-full-touch">
            <div class="panel">
                <div class="panel-block">
                    <div class="control field">
                        <label for="reaction_emoji">
                            <b>Emoji</b> - Either a <code>CustomEmoji</code> without colons, or a <a
                                target="_blank"
                                href="https://emojipedia.org">standard unicode emoji</a> <code>🙃</code>
                        </label>
                        <input
                            id="reaction_emoji"
                            v-model="emoji"
                            type="text"
                            class="input">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";

export default {
    name: "ReactionRolesEmoji",
    components: {
        PanelList
    },
    computed: {
        selectedRole() {
            return this.$store.state.reactionRoles.selectedRole;
        },
        getters() {
            return this.$store.getters;
        },
        emoji: {
            get() {
                return this.selectedRole.emoji;
            },
            set(emoji) {
                this.$store.dispatch("reactionRoles/changeField", {
                    field: "emoji",
                    value: emoji
                });
            },
        },
        availableRoles: {
            get() {
                return this.getters["reactionRoles/availableRoles"];
            },
            set(role) {
                this.$store.dispatch("reactionRoles/addRole", role);
            },
        },
        addedRoles: {
            get() {
                return this.getters["reactionRoles/addedRoles"];
            },
            set(role) {
                this.$store.dispatch("reactionRoles/removeRole", role);
            },
        }
    }
};
</script>
