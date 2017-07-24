<template>
    <input class="form-control" type="text" :id="id" :name="name" :value="value" @input="updateCommandCharacter">
</template>

<script>
    import {updateCommandCharacter} from '../vuex/actions'

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
                return this.$store.state.CommandCharacter
            }
        },
        methods: {
            updateCommandCharacter (e) {
                this.$store.dispatch('updateCommandCharacter', e.target.value)
            }
        },
        created() {
            this.$store.dispatch('updateCommandCharacter', this.initValue)
        }
    }
</script>