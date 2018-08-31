<template>
    <switch-input 
        :name="storeName" 
        v-model="value">
        <slot/>
    </switch-input>
</template>

<script>
import SwitchInput from "../../shared/form/SwitchInput";
export default {
    name: "VuexSwitch",
    components: {
        SwitchInput
    },
    props: {
        storeName: {
            type: String,
            required: true
        }
    },
    computed: {
        get() {
            //store
        },
        set(value) {
            //dispatch store
        }
    }
};
</script>
