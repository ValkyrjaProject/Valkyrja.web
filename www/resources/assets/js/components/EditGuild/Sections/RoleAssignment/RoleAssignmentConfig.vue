<template>
    <div>
        <div>
            <p>
                <b>Public Roles</b>
            </p>
            <p>
                Public Roles can be taken by anyone using the <code>@{{ command_prefix }}join</code> command. Please see the documentation for detailed command reference.
            </p>
            <p>
                These default to <code>No group</code> where any user can <code>@{{ command_prefix }}join</code> any of these roles. Any other public role group will be exclusive, and the user can have only one role out of a group at the time. You can have multiple groups.
            </p>
            <public-role-selector />
        </div>
        <br>
        <div>
            <b>Reaction Assigned Roles</b>
            <reaction-roles />
        </div>
    </div>
</template>

<script>
import PublicRoleSelector from "./PublicRoleSelector/PublicRoleSelector";
import ReactionRoles from "./ReactionRoles/ReactionRoles";

export default {
    name: "RoleAssignmentConfig",
    components: {
        PublicRoleSelector,
        ReactionRoles,
    },
    computed: {
        command_prefix() {
            return this.config("command_prefix");
        }
    },
    methods: {
        config(name) {
            return this.$store.getters.configInput(name).toString();
        }
    }
};
</script>

<style scoped>

</style>
