<template>
    <input class="form-control" type="text" :id="id" :name="name" v-model="value">
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
            value: {
                get() {
                    return this.$store.state[this.name]
                },
                set(e) {
                    this.$store.dispatch('updateStoreValue', {
                        key: this.initName,
                        data: e.target.value
                    })
                }
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
