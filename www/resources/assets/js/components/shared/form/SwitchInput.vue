<template>
    <div class="field">
        {{ boolValue }}
        <input 
            :id="name" 
            :name="name" 
            :value="boolValue" 
            type="checkbox"
            class="switch is-success"
            @input="$emit('input', $event.target.value)">
        <label :for="name">
            <slot/>
        </label>
    </div>
</template>

<script>
export default {
    name: "SwitchInput",
    props: {
        name: {
            type: String,
            required: true
        },
        value: {
            type: Boolean|Number,
            required: true,
            default: false
        }
    },
    computed: {
        boolValue() {
            return this.value === true;
        }
    }
};
</script>