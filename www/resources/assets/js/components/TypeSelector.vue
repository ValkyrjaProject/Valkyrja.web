<template>
    <div class="inline">
        <v-select :value.sync="selected" :label="label" :options="values" :on-change="updateSelected" placeholder="Empty"></v-select>
        <input class="form-control" type="hidden" :name="initIdType" v-model="selectedValue">
    </div>
</template>

<script>
    import vSelect from 'vue-select'
    export default {
        props: {
            values: {
                type: Array
            },
            defaultValue: {
                type: Object
            },
            initIdType:  {
                type: String
            },
            label:  {
                type: String
            }
        },
        data: function () {
            return {
                selected: this.defaultValue || ''
            }
        },
        components: {
            'v-select': vSelect
        },
        computed: {
            selectedValue: {
                // getter
                get: function () {
                    //Calculate which is the selected one
                    if (typeof this.selected['id'] === 'undefined') return '';
                    return this.selected['id']
                },
                // setter
                set: function (value) {
                    this.selected = value || '';
                }
            }
        },
        methods: {
            getValues: function (values) {
                if (typeof values === 'undefined' || !values) {
                    return '';
                }
                const array_values = [];
                for (const key in values) {
                    if (values.hasOwnProperty(key)) {
                        array_values.push(values[key]);
                    }
                }
                return array_values
            },
            updateSelected: function (value) {
                this.selectedValue = value;
            }
        }
    }
</script>