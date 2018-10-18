<template>
    <label :for="storeName">
        <slot></slot>
        <input
            :id="storeName"
            :name="storeName"
            v-model="inputValue"
            type="text"
            class="input">
    </label>
</template>

<script>
export default {
    name: "VuexText",
    props: {
        storeName: {
            type: String,
            required: true
        }
    },
    computed: {
        inputValue: {
            get() {
                return this.$store.getters.configInput(this.storeName);
            },
            set(value) {
                this.$store.dispatch("changeConfig", {
                    storeName: this.storeName,
                    value: value
                });
            }
        }
    }
};
</script>

<style scoped>

</style>
