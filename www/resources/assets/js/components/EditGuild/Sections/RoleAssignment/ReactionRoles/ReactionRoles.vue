<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <panel-list
                v-model="reactionRoles"
                :add-button="true"
                title="Messages"
                class="column is-one-third"/>
            <reaction-roles-form class="column is-two-thirds" />
        </div>
    </div>
</template>

<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";
import ReactionRolesForm from "./ReactionRolesForm";

export default {
    name: "ReactionRoles",
    components: {
        PanelList,
        ReactionRolesForm
    },
    computed: {
        getters() {
            return this.$store.getters;
        },
        reactionRoles: {
            get() {
                return this.getters["reactionRoles/roles"];
            },
            set(role) {
                this.$store.dispatch("reactionRoles/addReactionRole", role);
            },
        }
    },
};
</script>

<style scoped>

</style>
