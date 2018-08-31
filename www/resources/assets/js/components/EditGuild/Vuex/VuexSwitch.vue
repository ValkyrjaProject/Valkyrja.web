<template>
    <div class="field is-horizontal">
        <input
            :id="storeName"
            :name="storeName"
            v-model="inputValue"
            :true-value="1"
            :false-value="0"
            type="checkbox"
            class="switch is-success">
        <label :for="storeName">
            <slot/>
        </label>
    </div>
</template>

<script>
export default {
    name: "VuexSwitch",
    props: {
        storeName: {
            type: String,
            required: true
        }
    },
    computed: {
        inputValue: {
            get() {
                return this.$store.getters.configInput(this.storeName).value;
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
