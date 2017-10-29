<template>
    <div class="customComponent loadComponent">
        <div class="listRow">
            <div class="listContainer">
                <h2>Role type</h2>
                <select name="title" class="form-control" title="" style="width:100%;margin-bottom:5px" v-model="selectedPermissionLevel">
                    <option :value="level" v-for="(level, name) in RolePermissionLevelEnum">{{ name }}</option>
                </select>
            </div>
            <div class="listContainer">
                <h2>Public Role Group</h2>
                <div class="input-group">
                    <span class="input-group-addon itemLeft btn btn-secondary" :class="{'disabled': !publicRoleIsSelected}" @click="addPublicGroup()">+</span>
                    <select name="title" class="form-control" title="" v-model="selectedPublicGroup" :disabled="!publicRoleIsSelected">
                        <!--<option :value="0"></option>-->
                        <option :value="group.id" v-for="group in sortedPublicGroups">{{ group.name }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="listRow">
            <div class="listContainer">
                <h2>Available {{idType}}s</h2>
                <list-container v-model="typeAvailable"
                                :form-name="initFormName"
                                :hide-form="true"
                                :include-search="true"></list-container>
            </div>
            <div class="listContainer">
                <h2>Added {{idType}}s</h2>
                <list-container :value="addedTypesLevel"
                                @input="removeItem($event)"
                                :form-name="initFormName"
                                :hide-form="true"
                                :include-search="true"></list-container>
            </div>
        </div>
        <slot :addedTypesLevel="addedTypes"></slot>
    </div>
</template>

<script>
    import ListContainer from '../components/ListContainer.vue'
    import {addItem, removeItem} from '../vuex/actions'

    export default {
        components: {
            ListContainer
        },
        props: {
            value: {
                type: Object,
                required: false,
                default: function () {
                    return {}
                }
            },
            initFormName: {
                type: String,
                required: true
            },
            initIdType:  {
                type: String,
                required: true
            },
            hideInputs: {
                type: Boolean,
                required: false,
                default: false
            },
            stateIndex: {
                type: Number,
                required: false
            }
        },
        data: function () {
            return {
                idType: this.initIdType,
                queryAvailable: '',
                querySelected: '',
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
        created () {
            for (let type of this.addedTypes) {
                if (
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
                return this.$store.state.itemModifier[this.initFormName].itemsList;
            },
            formInputName () {
                return this.initFormName + '[]';
            },
            typeAvailable: {
                get () {
                    return this.$store.state[this.idType.toLowerCase()+'s'].filter(e => {
                        return this.addedTypes.filter(t => {
                            return t[[this.idType.toLowerCase()+'id']] === e.id
                        }).length === 0;
                    });
                },
                set (value) {
                    let newType = {};
                    newType[this.idType.toLowerCase()+'id'] = value.id;
                    newType['permission_level'] = this.selectedPermissionLevel;
                    newType['public_id'] = this.publicRoleIsSelected ? this.selectedPublicGroup : 0;
                    this.$store.dispatch('addItem', {
                        formName: this.initFormName,
                        item: newType
                    });
                }
            },
            addedTypesLevel() {
                return this.$store.state[this.idType.toLowerCase()+'s'].filter(e => {
                    return !(this.addedTypes.filter(t => t[[this.idType.toLowerCase()+'id']] === e.id
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
                let groups = this.publicGroups.sort(function(a,b){return a - b});
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
                let removeItem = this.addedTypes[this.addedTypes.findIndex(t => t[[this.idType.toLowerCase()+'id']] === item.id)];
                this.$store.dispatch('removeItem', {
                    formName: this.initFormName,
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