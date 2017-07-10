<template>
    <div class="inputList">
        <div class="listContainer">
            <h2>{{ title }}</h2>
            <div class="input-group">
                <input class="form-control" type="text" v-model.trim="content" placeholder="Add ID" @keypress.enter.prevent="addItem">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button" @click="addItem">+</button>
                </span>
            </div>
            <div class="dragArea selectList">
                <input type="hidden" :name="inputName" value="">
                <div v-for="item in values" class="listItem" @click="remove(item)">
                    {{item}}
                    <input type="hidden" :name="formInputName" :value="item">
                </div>
                <div class="listItem empty" v-if="!values.length">Empty</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                required: false
            },
            initValues: {
                type: Array,
                required: false
            },
            formName: {
                type: String,
                required: true
            }
        },
        data: function () {
            return {
                values: this.initValues || [],
                content: '',
                inputName: this.formName
            }
        },
        computed: {
            formInputName () {
                return this.inputName + '[]';
            }
        },
        methods: {
            addItem: function () {
                if (isNaN(this.content) || this.content.length === 0) return;

                if (this.values.indexOf(this.content) === -1) {
                    this.values.push(this.content);
                }
                this.content = ''
            },
            remove: function (item) {
                this.values.splice(this.values.findIndex(x => x===item), 1);
            }
        }
    }
</script>