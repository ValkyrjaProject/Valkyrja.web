<template>
    <div class="customComponent loadComponent">
        <div class="listRow">
            <div class="listContainer">
            </div>
            <div class="listContainer">
                <h2>Role type</h2>
                <select name="title" class="form-control" title="" style="width:100%;margin-bottom:5px"
                        v-model="selectedPermissionLevel">
                    <option :value="level" v-for="(level, name) in RolePermissionLevelEnum">{{ name }}</option>
                </select>
            </div>
        </div>
        <div class="listRow">
            <div class="listContainer">
                <h2>Available roles</h2>
                <list-container v-model="typeAvailable"
                                :hide-form="true"
                                :include-search="true"></list-container>
            </div>
            <div class="listContainer">
                <h2>Added roles</h2>
                <list-container :value="addedTypesLevel"
                                @input="removeItem($event)"
                                :hide-form="true"
                                :include-search="true"></list-container>
            </div>
        </div>
        <slot :addedTypesLevel="addedTypes"></slot>
    </div>
</template>

<script>
    import ListContainer from '../components/ListContainer.vue'
    import {addRole, removeRole} from '../vuex/actions'

    export default {
        components: {
            ListContainer
        },
        data: function () {
            return {
                RolePermissionLevelEnum: {
                    //None: "0",
                    //Public: "1",
                    Member: "2",
                    SubModerator: "3",
                    Moderator: "4",
                    Admin: "5"
                },
                selectedPermissionLevel: "2",
            }
        },
        created() {
            for (let type of this.addedTypes) {
                if (typeof(type.permission_level) === "undefined" || typeof(type.public_id) === "undefined") {
                    this.$store.dispatch('removeItem', {
                        formName: 'roles',
                        item: type
                    });
                }
            }
        },
        computed: {
            addedTypes() {
                return this.$store.state.itemModifier.roles.itemsList;
            },
            formInputName() {
                return 'roles[]';
            },
            typeAvailable: {
                get() {
                    return this.$store.state['roles'].filter(e => {
                        return this.addedTypes.filter(t => {
                            return t[['roleid']] === e.id
                                && parseInt(t[['permission_level']]) > 0;
                        }).length === 0;
                    });
                },
                set(role) {
                    // Add new role
                    let roles = this.addedTypes.filter(r => r[['roleid']] === role.id);
                    let newRole = {};
                    newRole['roleid'] = role.id;
                    newRole['permission_level'] = this.selectedPermissionLevel;
                    newRole['public_id'] = "0";
                    if (roles.length > 0) {
                        let roleToChange = roles[0];
                        this.$store.dispatch('updateRole', {
                            role: roleToChange,
                            data: newRole
                        })
                    }
                    else {
                        newRole['antispam_ignored'] = false;
                        this.$store.dispatch('addRole', {
                            formName: 'roles',
                            item: newRole
                        });
                    }
                }
            },
            addedTypesLevel() {
                return this.$store.state['roles'].filter(e => {
                    return !(this.addedTypes.filter(t => t[['roleid']] === e.id
                            && t.permission_level === this.selectedPermissionLevel
                        ).length === 0
                    )
                });
            },
        },
        methods: {
            removeItem(item) {
                let removeItem = this.addedTypes[this.addedTypes.findIndex(t => t[['roleid']] === item.id)];
                this.$store.dispatch('removeRole', {
                    formName: 'roles',
                    item: removeItem
                });
            }
        }
    }
</script>

<style lang="scss">
    .indent {
        display: block;
        margin-left: 5px;
    }
</style>
