<template>
    <container>
        <input type="hidden" :name="name" value="0">
        <input class="form-control" style="display: inline" type="checkbox" :id="id" value="1" v-model="value" name="tos">
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
                data: !!this.initValue
            })
        }
    }
</script>
