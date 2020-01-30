<template>
    <container>
        <input type="hidden" :name="name" value="0">
        <input class="form-control" style="display: inline" type="checkbox" :id="id" value="1" @input="updateStoreValue" name="tos" :checked="value">
    </container>
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
