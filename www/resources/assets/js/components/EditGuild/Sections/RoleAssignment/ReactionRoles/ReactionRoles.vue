<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <panel-list
                v-model="reactionRoles"
                :add-button="true"
                :selected-item="selectedReactionRole"
                list-item="PanelListItemRemovable"
                title="Messages"
                class="column is-one-third"
                @remove="deleteRole"
                @add="addRole"/>
            <reaction-roles-form
                :disabled="!hasSelectedRole()"
                class="column is-two-thirds" />
        </div>
    </div>
</template>

<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";
import ReactionRolesForm from "./ReactionRolesForm";
import ReactionRole from "../../../../../models/ReactionRole";

export default {
    name: "ReactionRoles",
    components: {
        PanelList,
        ReactionRolesForm
    },
    computed: {
        state() {
            return this.$store.state.reactionRoles;
        },
        getters() {
            return this.$store.getters;
        },
        selectedReactionRole() {
            return this.state.selectedReactionRole;
        },
        reactionRoles: {
            get() {
                return this.getters["reactionRoles/roles"];
            },
            set(role) {
                this.$store.dispatch("reactionRoles/setActiveReactionRole", role);
            },
        }
    },
    methods: {
        addRole() {
            let role = ReactionRole.newInstance("", []);
            this.$store.dispatch("reactionRoles/addReactionRole", role);
        },
        deleteRole(role) {
            this.$store.dispatch("reactionRoles/removeReactionRole", role);
        },
        hasSelectedRole() {
            return this.selectedRole !== null;
        }
    },
};
</script>

<style scoped>

</style>
