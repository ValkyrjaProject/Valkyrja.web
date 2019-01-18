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
        reactionRoles: {
            get() {
                return [];
            },
            set(role) {

            }
        }
    },
};
</script>

<style scoped>

</style>
