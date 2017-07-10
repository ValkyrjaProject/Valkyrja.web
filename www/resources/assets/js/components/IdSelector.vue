<template>
    <div class="idSelector">
        <div class="listContainer">
            <h2>Available {{idType}}</h2>
            <div class="input-group">
                <input class="form-control" type="text" v-model="queryAvailable" placeholder="Search for..." @keypress.enter.prevent="addTop(filterAvailable, queryAvailable)">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button" @click="queryAvailable = ''">x</button>
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
                    <button class="btn btn-secondary" type="button" @click="querySelected = ''">x</button>
                </span>
            </div>
            <div class="dragArea selectList">
                <input type="hidden" :name="inputName" value="">
                <div v-for="item in filterSelected" class="listItem" @click="remove(item)">
                    {{item.name}}
                    <input type="hidden" :name="formInputName" :value="item.id">
                </div>
                <div class="listItem empty" v-if="!typeSelected.length && !querySelected">Empty</div>
                <div class="listItem empty" v-if="!filterSelected.length && querySelected">Not found</div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            initData: {
                type: Object,
                required: false
            },
            initFormName: {
                type: String,
                required: true
            },
            initIdType:  {
                type: String,
                required: true
            }
        },
        data: function () {
            return {
                typeAvailable: this.initData['available'] || [],
                typeSelected: this.initData['selected'] || [],
                inputName: this.initFormName,
                idType: this.initIdType,
                queryAvailable: '',
                querySelected: ''
            }
        },
        computed: {
            formInputName () {
                return this.inputName + '[]';
            },
            filterAvailable: function () {
                if (this.typeAvailable.length < 1) return [];
                return this.findBy(this.typeAvailable, this.queryAvailable, 'name')
            },
            filterSelected: function () {
                if (this.typeSelected.length < 1) return [];
                return this.findBy(this.typeSelected, this.querySelected, 'name')
            }
        },
        methods: {
            add: function (item) {
                this.typeAvailable.splice(this.typeAvailable.findIndex(x => x===item), 1);
                this.typeSelected.push(item);
                this.sortArray(this.typeSelected);
                this.clearQuery();
            },
            remove: function (item) {
                this.typeSelected.splice(this.typeSelected.findIndex(x => x===item), 1);
                this.typeAvailable.push(item);
                this.sortArray(this.typeAvailable);
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