<template>
    <input class="form-control" type="text" :id="id" :name="name" v-model="value" @keyup="changeHandler">
</template>

<script>
    export default {
        props: [
            'initId',
            'initName',
            'initValue'
        ],
        data: function () {
            return {
                id: this.initId,
                name: this.initName,
                value: this.initValue
            }
        },
        methods: {
            changeHandler() {
                this.$emit('input-event', this.value)
            }
        },
        created: function () {
            this.changeHandler();
        }
    }
</script>