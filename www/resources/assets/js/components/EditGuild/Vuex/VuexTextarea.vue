<template>
    <textarea 
        :id="storeName"
        :name="storeName"
        v-model="inputValue"
        class="textarea"
        type="text"></textarea>
</template>

<script>
export default {
    name: "VuexTextarea",
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
