<template>
    <vue-multiselect
        :options="options"
        :track-by="trackBy"
        :label="label"
        :value="value"
        :placeholder="placeholder"
        class="vue-multiselect"
        @input="$emit('input', $event)"/>
</template>

<script>
/* eslint-disable vue/require-default-prop */
import VueMultiselect from "vue-multiselect";
export default {
    name: "VuexMultiselect",
    components: {
        VueMultiselect,
    },
    props: {
        options: {
            type: Array,
            required: true
        },
        trackBy: {
            type: String,
        },
        label: {
            type: String,
        },
        placeholder: {
            type: String,
            default: "Select option",
        },
        value: {
            type: null,
            default () {
                return [];
            }
        },
    }
};
</script>


<style lang="scss">
    @import "../../../../sass/_variables.scss";
</style>
