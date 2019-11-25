<template>
    <div id="publicRoleSelector" class="box has-background-white-bis">
        <div class="columns">
            <div class="column is-one-third">
                <public-role-selector-group
                    title="Public Role Group"
                    class="content"
                />
            </div>
            <panel-list
                v-model="availableRoles"
                class="column roles is-one-third availableRoles"
                title="Available Roles"
            />
            <panel-list
                v-model="addedRoles"
                class="column roles is-one-third addedRoles"
                title="Added Roles"
            />
        </div>
    </div>
</template>

<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";
import PublicRoleSelectorGroup from "./PublicRoleSelectorGroup";
import {types} from "../../../../../store/modules/RoleSelector";

export default {
    name: "PublicRoleSelector",
    components: {
        PublicRoleSelectorGroup,
        PanelList,
    },
    computed: {
        state() {
            return this.$store.state.roleSelector;
        },
        getters() {
            return this.$store.getters;
        },
        availableRoles: {
            get() {
                return this.getters["roleSelector/availableRoles"];
            },
            set(role) {
                this.$store.dispatch("roleSelector/addPublicRole", role);
            },
        },
        addedRoles: {
            get() {
                return this.getters["roleSelector/addedRoles"](types.Public);
            },
            set(role) {
                this.$store.dispatch("roleSelector/removeRole", role);
            },
        },
    },
};
</script>

<style scoped>
    .roles.column {
        min-height: 310px;
    }
    .roles.column >>> .panel:last-child {
        min-height: inherit !important;
    }
</style>
