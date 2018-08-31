<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <role-selector-type
                title="test"
                class="column"
            />
            <role-selector-group
                :is-active="publicRoleSelected"
                title="test"
                class="column"
            />
        </div>
        <div class="columns roles">
            <panel-list
                v-model="availableRoles"
                class="column"
                title="Available Roles"
            />
            <panel-list
                v-model="addedRoles"
                class="column"
                title="Added Roles"
            />
        </div>
    </div>
</template>

<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";
import RoleSelectorType from "./RoleSelectorType";
import RoleSelectorGroup from "./RoleSelectorGroup";
import types from "../../../../../store/modules/RoleSelector";
import {createPublicRole} from "../../../../../models/PublicRole";

export default {
    name: "RoleSelector",
    components: {
        RoleSelectorType,
        RoleSelectorGroup,
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
                // TODO: Emit new role
                console.log("role", role);
                let publicRole = createPublicRole(role, 1, 1);
                this.$store.dispatch("roleSelector/addRole", publicRole);
            },
        },
        addedRoles: {
            get() {
                return this.getters["roleSelector/addedRoles"];
            },
            set(role) {
                // TODO: Emit new role
                console.log("role", role);
                this.$store.dispatch("roleSelector/removeRole", role);
            },
        },
        publicRoleSelected() {
            return this.state.selectedType === types.Public;
        },
    },
};
</script>

<style scoped>

    .roles .column {
        min-height: 270px;
    }
    .roles .column >>> .panel:last-child {
        min-height: inherit !important;
    }
</style>
