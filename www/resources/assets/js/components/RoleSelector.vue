<template>
    <div class="customComponent loadComponent">
        <div class="listRow">
            <div class="listContainer">
            </div>
            <div class="listContainer">
                <h2>Public Role Group</h2>
                <div class="input-group">
                    <span class="input-group-addon itemLeft btn btn-secondary" @click="addPublicGroup()">+</span>
                    <select name="title" class="form-control" title="" v-model="selectedPublicGroup">
                        <option :value="group.id" v-for="group in sortedPublicGroups">{{ group.toString() }}</option>
                    </select>
                </div>
                <div class="input-group">
                    <input type="text"
                           v-model="name"
                           class="form-control"
                           placeholder="Group name"
                           title="Group name"
                           :disabled="isEmptyGroupSelected"/>
                </div>
                <div class="input-group">
                    <span class="indent">
                        Number of roles from this group that the user can take:
                    </span>
                    <input type="number"
                           v-model="roleLimit"
                           class="form-control"
                           placeholder="Role limit"
                           title="Role limit"
                           :disabled="!isEmptyGroupSelected"/>
                </div>
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
        <slot :roleGroups="publicGroups"></slot>
    </div>
</template>

<script>
    import ListContainer from '../components/ListContainer.vue'
    import {addRole, removeRole} from '../vuex/actions'
    import {PublicRoleGroup, EmptyPublicRoleGroup} from '../models/PublicRoleGroup'

    const noGroup = new EmptyPublicRoleGroup(0);
    export default {
        components: {
            ListContainer
        },
        data: function () {
            return {
                selectedPermissionLevel: "1",
                selectedPublicGroup: noGroup.id,
                publicGroups: []
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
                else if (
                    type.permission_level === this.RolePermissionLevelEnum.Public
                    && type.public_id !== 0
                    && this.publicGroups.find(g => g.id === type.public_id) === undefined
                ) {
                    let role_group = this.roleGroups.find(role => role['groupid'].toString() === type.public_id.toString());
                    let publicRoleGroup = new PublicRoleGroup(type.public_id);
                    if (role_group) {
                        publicRoleGroup['name'] = role_group['name'];
                        publicRoleGroup['role_limit'] = role_group['role_limit'];
                    }
                    this.publicGroups.push(publicRoleGroup);
                }
            }
        },
        computed: {
            addedTypes() {
                return this.$store.state.itemModifier.roles.itemsList;
            },
            roleGroups() {
                return this.$store.state.itemModifier.role_groups.itemsList;
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
                    newRole['public_id'] = this.selectedPublicGroup;
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
            isEmptyGroupSelected() {
                return this.selectedPublicGroup === noGroup.id;
            },
            sortedPublicGroups() {
                return [noGroup].concat(this.publicGroups.sort(function (a, b) {
                    return a.id - b.id
                }));
            },
            roleLimit: {
                get() {
                    let group = this.getSelectedGroup();
                    if (!this.isEmptyGroupSelected && group !== undefined) {
                        return group.role_limit
                    }
                },
                set(limit) {
                    let group = this.getSelectedGroup();
                    if (!this.isEmptyGroupSelected && group !== undefined) {
                        group.role_limit = limit
                    }
                }
            },
            name: {
                get() {
                    let group = this.getSelectedGroup();
                    if (!this.isEmptyGroupSelected && group !== undefined) {
                        return group.name
                    }
                },
                set(limit) {
                    let group = this.getSelectedGroup();
                    if (!this.isEmptyGroupSelected && group !== undefined) {
                        group.name = limit
                    }
                }
            }
        },
        methods: {
            getSelectedGroup() {
                return this.publicGroups.find(g => g.id === this.selectedPublicGroup)
            },
            addPublicGroup() {
                let start = 1;
                while (this.publicGroups.find(g => parseInt(g.id) === start) !== undefined) start++;
                let group = new PublicRoleGroup(start);
                this.publicGroups.push(group);
                this.selectedPublicGroup = start.toString();
            },
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
