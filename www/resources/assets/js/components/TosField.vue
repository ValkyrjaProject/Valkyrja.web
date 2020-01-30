<template>
    <input class="form-control" style="display: inline" type="checkbox" v-model="value">
</template>

<script>
    export default {
        props: {
            'initValue': {
                required: false,
                default: null
            }
        },
        computed: {
            value: {
                get() {
                    return this.$store.state.tos
                },
                set(value) {
                    this.$store.dispatch('updateTOS', value);
                }
            }
        },
        created() {
            if (this.initValue !== null) {
                this.$store.dispatch('updateTOS', this.initValue)
            }
        }
    }
</script>
