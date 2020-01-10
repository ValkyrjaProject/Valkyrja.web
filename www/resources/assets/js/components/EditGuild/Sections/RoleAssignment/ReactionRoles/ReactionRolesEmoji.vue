<template>
    <div class="columns is-desktop is-root is-gapless">
        <div class="columns column is-marginless is-gapless">
            <panel-list
                v-model="availableRoles"
                :remove-radius="true"
                item-key="id"
                title="Available Roles"
                class="column is-half" />
            <panel-list
                :value="addedRoles"
                :remove-radius="true"
                :selected-item="selectedEmojiRole"
                list-item="PanelListItemRemovable"
                item-key="id"
                title="Added Roles"
                class="column is-half is-radiusless"
                @input="selectEmojiRole"
                @remove="removeRole"
            />
        </div>
        <div
            class="column is-one-third is-full-touch">
            <div
                v-if="!emojiRole"
                class="panel">
                <div class="panel-block">Select a role to add an emoji.</div>
            </div>
            <div
                v-else
                class="panel">
                <p class="panel-heading">
                    Emoji for {{ selectedEmojiRole }}
                </p>
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
                            class="input"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";
import EmojiRole from "../../../../../models/EmojiRole";

export default {
    name: "ReactionRolesEmoji",
    components: {
        PanelList
    },
    data() {
        return {
            emojiRole: null
        };
    },
    computed: {
        selectedReactionRole() {
            return this.$store.state.reactionRoles.selectedReactionRole;
        },
        getters() {
            return this.$store.getters;
        },
        emoji: {
            get() {
                return this.emojiRole ? this.emojiRole.emoji : null;
            },
            set(emoji) {
                if (this.emojiRole) {
                    this.emojiRole.emoji = emoji;
                }
            },
        },
        availableRoles: {
            get() {
                return this.getters["reactionRoles/availableRoles"];
            },
            set(role) {
                // Create a new reaction role here
                let emojiRole = new EmojiRole(role, "");
                this.$store.dispatch("reactionRoles/addRole", emojiRole);
            },
        },
        addedRoles() {
            return this.getters["reactionRoles/addedRoles"];
        },
        selectedEmojiRole() {
            if (this.emojiRole) {
                return this.addedRoles.find(r => r.id === this.emojiRole.id);
            }
        }
    },
    methods: {
        removeRole(role) {
            this.$store.dispatch("reactionRoles/removeRole", role);
            if (!this.addedRoles || role === this.emojiRole) {
                this.emojiRole = null;
            }
        },
        selectEmojiRole(role) {
            this.emojiRole = this.selectedReactionRole.roles.find(r => r.id === role.id);
        },
    },
};
</script>
