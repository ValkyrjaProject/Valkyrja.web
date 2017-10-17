\<template>
    <div class="idSelector loadComponent">
        <div class="listContainer">
            <h2>Available {{idType}}s</h2>
            <list-container v-model="typeAvailable"
                            :form-name="initFormName"
                            :hide-form="true"
                            :include-search="true"></list-container>
        </div>
        <div class="listContainer">
            <h2>Added {{idType}}s</h2>
            <select name="title" class="form-control" title="" style="width:100%;margin-bottom:5px" v-model="selectedPermissionLevel">
                <option :value="level" v-for="(level, name) in RolePermissionLevelEnum">{{ name }}</option>
            </select>
            <list-container :value="addedTypesLevel"
                            @click="removeItem($event)"
                            :form-name="initFormName"
                            :hide-form="true"
                            :include-search="true"></list-container>
        </div>
        <slot :addedTypesLevel="addedTypes"></slot>
        <!--<span v-if="hideInputs">
        </span>-->
        <!--<div class="listContainer">
            <h2>Selected</h2>
            <p>{{ selectedType }}</p>
            <select name="title" id="title" class="form-control" v-model="selectedType.permission_level">
                <option :value="level" v-for="(level, name) in RolePermissionLevelEnum">{{ name }}</option>
            </select>
            <list-container :value="RolePermissionLevelEnum"
                            :form-name="initFormName"
                            :hide-form="true"
                            :include-search="false"></list-container>
        </div>-->
    </div>
</template>

<script>
    import ListContainer from '../components/ListContainer.vue'
    import {editRole, editChannel, removeRole, removeChannel} from '../vuex/actions'

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
                addedTypes: [],
                selectedType: {},
                RolePermissionLevelEnum: {
                    //None: 0,
                    Public: 1,
                    Member: 2,
                    SubModerator: 3,
                    Moderator: 4,
                    Admin: 5
                },
                selectedPermissionLevel: 1
            }
        },
        computed: {
            formInputName () {
                return this.initFormName + '[]';
            },
            types () {
                return this.$store.getters[this.idType.toLowerCase()+'s'];
            },
            typeAvailable: {
                get () {
                    return this.$store.state[this.idType.toLowerCase()+'s'].filter(e => {
                        return this.addedTypes.filter(t => t[[this.idType.toLowerCase()+'id']] === e.id).length === 0;
                    });
                },
                set (value) {
                    let newType = {};
                    newType[this.idType.toLowerCase()+'id'] = value.id;
                    newType['name'] = value.name;
                    newType['permission_level'] = this.selectedPermissionLevel;
                    this.addedTypes.push(newType);
                    if (this.addedTypes.length === 1) {
                        this.selectedType = newType;
                    }
                }
            },
            addedTypesLevel() {
                return this.addedTypes.filter(t => t.permission_level === this.selectedPermissionLevel);
            }
        },
        methods: {
            removeItem(item) {
                this.addedTypes.splice(this.addedTypes.findIndex(x => x === item), 1);
            }
        }
    }
</script>