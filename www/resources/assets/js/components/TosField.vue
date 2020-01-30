<template>
    <container>
        <input class="form-control" style="display: inline" type="checkbox" v-model="value">
    </container>
</template>

<script>
    export default {
        props: [
            'initName',
            'initValue'
        ],
        data: function () {
            return {
                name: this.initName,
            }
        },
        computed: {
            value: {
                get() {
                    return this.$store.state[this.name]
                },
                set(e) {
                    this.$store.dispatch('updateTOS', e.target.value);
                }
            }
        },
        created() {
            this.$store.dispatch('updateTOS', this.initValue)
        }
    }
</script>
