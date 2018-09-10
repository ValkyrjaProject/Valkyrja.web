<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <div class="column">
                <role-selector-type
                    title="Role type"
                    class="content"
                />
                <role-selector-group
                    :is-active="publicRoleSelected"
                    title="Public Role Group"
                    class="content"
                />
            </div>
            <panel-list
                v-model="availableRoles"
                class="column roles"
                title="Available Roles"
            />
            <panel-list
                v-model="addedRoles"
                class="column roles"
                title="Added Roles"
            />
        </div>
    </div>
</template>

<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";
import RoleSelectorType from "./RoleSelectorType";
import RoleSelectorGroup from "./RoleSelectorGroup";
import { types } from "../../../../../store/modules/RoleSelector";

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
                this.$store.dispatch("roleSelector/addRole", role);
            },
        },
        addedRoles: {
            get() {
                return this.getters["roleSelector/addedRoles"];
            },
            set(role) {
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
    .roles.column {
        min-height: 310px;
    }
    .roles.column >>> .panel:last-child {
        min-height: inherit !important;
    }
</style>
