<template>
    <div>
        <div v-if="includeSearch" class="input-group">
            <input class="form-control" v-model="query" placeholder="Search for..." @keypress.enter.prevent="inputFromSearch(filterValue, query)">
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="button" @click="query = ''">✕</button>
            </span>
        </div>
        <div class="dragArea selectList">
            <div v-if="listType === 'flat'">
                <div v-for="item in filterValue" class="listItem" @click="input(item)" :key="item[idAttribute]" :class="item.classData">
                    {{item[displayAttribute].trim().substring(0, 25)}}
                </div>
            </div>
            <div v-else-if="listType === 'doubleInput'">
                <div class="listItem listItemGroup input-group" v-for="item in filterValue" :class="item.classData">
                    <div class="input-group-addon" @click="click(item)">✕</div>
                    <span class="itemLeft btn" @click="input(item)">{{item[displayAttribute].trim().substring(0, 25)}}</span>
                </div>
            </div>
            <span v-if="!hideForm">
                <input v-for="item in value" type="hidden" :name="formInputName" :value="item[idAttribute]" :key="item[idAttribute]">
            </span>
            <div class="listItem empty" v-if="!value.length">Empty</div>
            <div class="listItem empty" v-if="value.length && !filterValue.length && query">Not found</div>
        </div>
        <a v-if="canAdd" class="listItem centerText" @click="addItem()">
            +
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            /**
             * Form name used for form inputs. Not used if hideForm prop is true
             */
            formName: {
                type: String,
                required: false
            },
            /**
             * Requires id and name attributes. ID for form inputs. Name for displaying
             */
            value: {
                type: Array,
                required: true
            },
            /**
             * Hide the form input to avoid in form submit
             */
            hideForm: {
                type: Boolean,
                required: false,
                default: false
            },
            /**
             * Include search bar to filter results
             */
            includeSearch: {
                type: Boolean,
                required: false,
                default: true
            },
            /**
             * Should you be allowed to add items through button?
             */
            canAdd: {
                type: Boolean,
                required: false,
                default: false
            },
            /**
             * 'flat' for single element to click on. 'doubleInput' for close button and element to click on
             */
            listType: {
                type: String,
                required: false,
                default: 'flat'
            },
            /**
             * For which attribute in input to display and search by.
             */
            displayAttribute: {
                type: String,
                required: false,
                default: 'name'
            },
            /**
             * ID name to use as value
             */
            idAttribute: {
                type: String,
                required: false,
                default: 'id'
            }
        },
        data: function () {
            return {
                query: ''
            };
        },
        computed: {
            formInputName () {
                return this.formName + '[]';
            },
            filterValue () {
                if (this.value.length < 1) return [];
                return this.findBy(this.value, this.query, this.displayAttribute)
            }
        },
        methods: {
            input: function (item) {
                this.$emit('input', item);
                this.query = '';
            },
            click: function (item) {
                this.$emit('click', item);
                this.query = '';
            },
            addItem: function () {
                this.$emit('add');
                this.query = '';
            },
            findBy: function (list, value, column) {
                return list.filter(function (item) {
                    return item[column].toLowerCase().includes(value.toLowerCase())
                })
            },
            inputFromSearch: function (list, query) {
                if (list.length < 1 || query.length < 1) return;
                this.input(list[0])
            }
        }
    }
</script>