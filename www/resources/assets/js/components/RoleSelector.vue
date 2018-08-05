<template>
    <div class="customComponent loadComponent">
        <div class="listRow">
            <div class="listContainer">
                <h2>Role type</h2>
                <select name="title" class="form-control" title="" style="width:100%;margin-bottom:5px"
                        v-model="selectedPermissionLevel">
                    <option :value="level" v-for="(level, name) in RolePermissionLevelEnum">{{ name }}</option>
                </select>
            </div>
            <div class="listContainer">
                <h2>Public Role Group</h2>
                <div class="input-group">
                    <span class="input-group-addon itemLeft btn btn-secondary"
                          :class="{'disabled': !publicRoleIsSelected}" @click="addPublicGroup()">+</span>
                    <select name="title" class="form-control" title="" v-model="selectedPublicGroup"
                            :disabled="!publicRoleIsSelected">
                        <!--<option :value="0"></option>-->
                        <option :value="group.id" v-for="group in sortedPublicGroups">{{ group.name }}</option>
                    </select>
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
    </div>
</template>

<script>
    import ListContainer from '../components/ListContainer.vue'
    import {addRole, removeRole} from '../vuex/actions'

    export default {
        components: {
            ListContainer
        },
        props: {
            value: {
                type: Object,
                required: false,
            },
            hideInputs: {
                type: Boolean,
                required: false,
                default: true
            },
            stateIndex: {
                type: Number,
                required: false
            }
        },
        data: function () {
            return {
                RolePermissionLevelEnum: {
                    //None: "0",
                    Public: "1",
                    Member: "2",
                    SubModerator: "3",
                    Moderator: "4",
                    Admin: "5"
                },
                selectedPermissionLevel: "1",
                selectedPublicGroup: "1",
                publicGroups: [
                    "0"
                ]
            }
        },
        created() {
            console.log(this.addedTypes);
            for (let type of this.addedTypes) {
                if (typeof(type.permission_level) === "undefined" || typeof(type.public_id) === "undefined") {
                    this.$store.dispatch('removeItem', {
                        formName: 'roles',
                        item: type
                    });
                }
                else if (
                    type.permission_level === this.RolePermissionLevelEnum.Public
                    && this.publicGroups.indexOf(type.public_id) === -1
                ) {
                    this.publicGroups.push(type.public_id);
                }
            }
            this.selectedPublicGroup = this.publicGroups[0];
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
                    newRole['public_id'] = this.publicRoleIsSelected ? this.selectedPublicGroup : 0;
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
                            && (this.publicRoleIsSelected ? t.public_id === this.selectedPublicGroup : 1)
                        ).length === 0
                    )
                });
            },
            publicRoleIsSelected() {
                return this.selectedPermissionLevel === this.RolePermissionLevelEnum.Public;
            },
            sortedPublicGroups() {
                let groups = this.publicGroups.sort(function (a, b) {
                    return a - b
                });
                let newGroups = [];
                for (let group of groups) {
                    let newGroup = [];
                    newGroup['id'] = group;
                    newGroup['name'] = this.groupName(group);
                    newGroups.push(newGroup);
                }
                console.log(newGroups);
                return newGroups;
            }
        },
        methods: {
            addPublicGroup() {
                if (this.publicRoleIsSelected) {
                    let start = 0;
                    this.publicGroups.every(e => {
                        if (parseInt(e) === start) {
                            start = parseInt(e) + 1;
                            return true;
                        }
                    });
                    start = start.toString();
                    this.publicGroups.push(start);
                    this.selectedPublicGroup = start;
                }
            },
            removeItem(item) {
                let removeItem = this.addedTypes[this.addedTypes.findIndex(t => t[['roleid']] === item.id)];
                this.$store.dispatch('removeRole', {
                    formName: 'roles',
                    item: removeItem
                });
            },
            groupName(item) {
                if (item === "0") {
                    return "No group";
                }
                return "Group " + item;
            }
        }
    }
</script>