<template>
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
                            @input="removeItem($event)"
                            :form-name="initFormName"
                            :hide-form="true"
                            :include-search="true"></list-container>
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
                selectedPermissionLevel: "1"
            }
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
                        return this.addedTypes.filter(t => t[[this.idType.toLowerCase()+'id']] === e.id).length === 0;
                    });
                },
                set (value) {
                    let newType = {};
                    newType[this.idType.toLowerCase()+'id'] = value.id;
                    newType['permission_level'] = this.selectedPermissionLevel;
                    this.$store.dispatch('addItem', {
                        formName: this.initFormName,
                        item: newType
                    });
                }
            },
            addedTypesLevel() {
                return this.$store.state[this.idType.toLowerCase()+'s'].filter(e => {
                    return !(this.addedTypes.filter(t => t[[this.idType.toLowerCase()+'id']] === e.id
                        && t.permission_level === this.selectedPermissionLevel).length === 0)
                });
            }
        },
        methods: {
            removeItem(item) {
                let removeItem = this.addedTypes[this.addedTypes.findIndex(t => t[[this.idType.toLowerCase()+'id']] === item.id)];
                this.$store.dispatch('removeItem', {
                    formName: this.initFormName,
                    item: removeItem
                });
            }
        }
    }
</script>