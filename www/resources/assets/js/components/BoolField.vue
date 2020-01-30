<template>
    <container>
        <input class="form-control" style="display: inline" type="checkbox" :id="id" v-model="value">
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
                data: !!JSON.parse(String(!!this.initValue).toLowerCase())
            })
        }
    }
</script>
