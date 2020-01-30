<template>
    <input class="form-control" type="text" :id="id" :name="name" :value="value" @input="updateStoreValue">
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
            }
        },
        computed: {
            value () {
                return this.$store.state[this.name]
            }
        },
        methods: {
            updateStoreValue (e) {
                this.$store.dispatch('updateStoreValue', {
                    key: this.initName,
                    data: e.target.value
                })
            }
        },
        created() {
            this.$store.dispatch('updateStoreValue', {
                key: this.initName,
                data: this.initValue
            })
        }
    }
</script>
