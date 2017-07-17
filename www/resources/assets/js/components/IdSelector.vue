<template>
    <div class="idSelector loadComponent">
        <div v-if="isLoading" class="loading">
            <span>Loading config please wait!</span>
        </div>
        <div class="listContainer">
            <h2>Available {{idType}}</h2>
            <div class="input-group">
                <input class="form-control" type="text" v-model="queryAvailable" placeholder="Search for..." @keypress.enter.prevent="addTop(filterAvailable, queryAvailable)">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button" @click="queryAvailable = ''">✕</button>
                </span>
            </div>
            <div class="dragArea selectList">
                <div v-for="item in filterAvailable" class="listItem" @click="add(item)">
                    {{item.name}}
                </div>
                <div class="listItem empty" v-if="!typeAvailable.length && !queryAvailable">Empty</div>
                <div class="listItem empty" v-if="!filterAvailable.length && queryAvailable">Not found</div>
            </div>
        </div>
        <div class="listContainer">
            <h2>Selected {{idType}}</h2>
            <div class="input-group">
                <input class="form-control" type="text" v-model="querySelected" placeholder="Search for..." @keypress.enter.prevent="removeTop(filterSelected, querySelected)">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button" @click="querySelected = ''">✕</button>
                </span>
            </div>
            <div class="dragArea selectList">
                <div v-for="item in filterSelected" class="listItem" @click="remove(item)">
                    {{item.name}}
                </div>
                <span v-if="!hideInputs">
                    <input v-for="item in typeSelected" type="hidden" :name="formInputName" :value="item.id">
                </span>
                <div class="listItem empty" v-if="!typeSelected.length && !querySelected">Empty</div>
                <div class="listItem empty" v-if="!filterSelected.length && querySelected">Not found</div>
            </div>
        </div>
    </div>
</template>

<script>
    import {editData, removeData} from '../vuex/actions'

    export default {
        props: {
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
                isLoading: false
            }
        },
        created () {
            if (this.initFormName !== 'CustomCommands') {
                this.isLoading = true;
                this.$store.dispatch('updateState', this.initFormName)
                    .then(() => {
                            this.isLoading = false;
                        });
            }
        },
        computed: {
            formInputName () {
                return this.initFormName + '[]';
            },
            types () {
                let commands;
                if (this.initFormName === 'CustomCommands') {
                    commands = this.$store.getters[this.initFormName.toLowerCase()](this.stateIndex);
                }
                else {
                    commands = this.$store.getters[this.idType.toLowerCase()](this.initFormName)
                }
                if (commands === null) {
                    return []
                }
                return commands;
            },
            typeAvailable () {
                return this.types['available'] || []
            },
            typeSelected () {
                return this.types['selected'] || []
            },
            filterAvailable () {
                if (this.typeAvailable.length < 1) return [];
                return this.findBy(this.typeAvailable, this.queryAvailable, 'name')
            },
            filterSelected () {
                if (this.typeSelected.length < 1) return [];
                return this.findBy(this.typeSelected, this.querySelected, 'name')
            }
        },
        methods: {
            add: function (item) {
                if (this.initFormName === 'CustomCommands') {
                    this.$store.dispatch('editCustomCommandsRoles', {key: this.stateIndex, data: item.id});
                }
                else {
                    this.$store.dispatch('editData', {key: this.initFormName, data: item.id});
                }
                this.clearQuery();
            },
            remove: function (item) {
                if (this.initFormName === 'CustomCommands') {
                    this.$store.dispatch('removeCustomCommandsRoles', {key: this.stateIndex, data: item.id });
                }
                else {
                    this.$store.dispatch('removeData', {key: this.initFormName, data: item.id });
                }
                this.clearQuery();
            },
            clearQuery: function () {
                this.queryAvailable = '';
                this.querySelected = '';
            },
            sortArray: function(array) {
                array.sort(function (a, b) {
                    const textA = a.name.toUpperCase();
                    const textB = b.name.toUpperCase();
                    return (textA < textB) ? -1 : (textA > textB) ? 1 : 0;
                })
            },
            findBy: function (list, value, column) {
                //return list;
                return list.filter(function (item) {
                    return item[column].toLowerCase().includes(value.toLowerCase())
                })
            },
            addTop: function (list, query) {
                if (list.length < 1 || query.length < 1) return;
                this.add(list[0])
            },
            removeTop: function (list, query) {
                if (list.length < 1 || query.length < 1) return;
                this.remove(list[0])
            }
        }
    }
</script>