<template>
    <!--:class="isInput ? 'input' : ''"-->
    <input 
        :type="type"
        :id="storeName"
        :name="storeName"
        v-model="inputValue"
        :min="min"
        :max="max"
        class="input"
    >
</template>

<script>
export default {
    name: "VuexNumber",
    props: {
        storeName: {
            type: String,
            required: true
        },
        typeInteger: {
            type: Boolean,
            required: false,
            default: true
        },
        min: {
            type: Number,
            required: false
        },
        max: {
            type: Number,
            required: false
        },
        isInput: {
            type: Boolean,
            required: false,
            default: false
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
                    value: parseInt(value)
                });
            }
        },
        type() {
            if (this.typeInteger) {
                return "number";
            }
            else {
                return "text";
            }
        }
    }
};
</script>

<style scoped>

</style>