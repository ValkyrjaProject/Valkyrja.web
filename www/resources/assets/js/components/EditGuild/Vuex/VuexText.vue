<template>
    <div>
        <label :for="storeName">
            <slot></slot>
            <input
                :id="storeName"
                :name="storeName"
                v-model="inputValue"
                :class="{'is-danger': $v.inputValue.$error }"
                type="text"
                class="input">
        </label>
        <p
            v-if="required && !$v.inputValue.required"
            class="help is-danger">Cannot be empty.</p>
        <p
            v-if="maxLength !== null && !$v.inputValue.maxLength"
            class="help is-danger">Can not exceed length of {{ maxLength }}.</p>
    </div>
</template>

<script>
import { maxLength, required } from "vuelidate/lib/validators";

export default {
    name: "VuexText",
    props: {
        storeName: {
            type: String,
            required: true
        },
        required: {
            type: Boolean,
            required: false,
            default: false
        },
        maxLength: {
            type: Number,
            required: false,
            default: null
        }
    },
    computed: {
        inputValue: {
            get() {
                return this.$store.getters.configInput(this.storeName).toString();
            },
            set(value) {
                this.$v.inputValue.$touch();
                this.$store.dispatch("changeConfig", {
                    storeName: this.storeName,
                    value: value
                });
            }
        }
    },
    validations() {
        let inputValue = {};
        if (this.maxLength) {
            inputValue["maxLength"] = maxLength(this.maxLength);
        }
        if (this.required) {
            inputValue["required"] = required;
        }
        console.log(this.storeName, inputValue);
        return {
            inputValue
        };
    }
};
</script>

<style scoped>

</style>
