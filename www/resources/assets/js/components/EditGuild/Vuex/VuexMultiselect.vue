<template>
    <vue-multiselect
        :id="storeName"
        v-model="inputValue"
        :placeholder="placeholder"
        :options="options"
        label="name"
        track-by="id"
        class="vue-multiselect">
        <template
            slot="option"
            slot-scope="props">
            <span
                v-if="itemIcon"
                class="icon is-small">
                <i
                    :class="'mdi mdi-' + itemIcon"
                    aria-hidden="true"></i>
            </span>
            {{ props.option.toString() }}
        </template>
        <template
            slot="singleLabel"
            slot-scope="props">
            <span
                v-if="itemIcon"
                class="icon is-small">
                <i
                    :class="'mdi mdi-' + itemIcon"
                    aria-hidden="true"></i>
            </span>
            {{ props.option.toString() }}
        </template>
    </vue-multiselect>
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
        storeName: {
            type: String,
            required: true
        },
        optionName: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            default: "Select option",
        },
        itemIcon: {
            type: String,
            default: null,
            required: false
        },
    },
    computed: {
        options() {
            let guildInfo = this.$store.state.guild[this.optionName];
            return [].concat(guildInfo ? guildInfo : []);
        },
        inputValue: {
            get() {
                return this.options.find(obj => obj.id === this.$store.getters.configInput(this.storeName).value);
            },
            set(value) {
                this.$store.dispatch("changeConfig", {
                    storeName: this.storeName,
                    value: value ? value.id : value
                });
            },
        }
    },
};
</script>

<style scoped>

</style>
