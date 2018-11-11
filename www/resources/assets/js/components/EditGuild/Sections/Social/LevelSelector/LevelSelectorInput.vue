<template>
    <div class="panel">
        <nav class="panel is-marginless panel-parent">
            <p class="panel-heading">
                Levels
            </p>
        </nav>
        <div class="panel-block has-background-white">
            <div class="is-fullwidth">
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <input
                            :value="currentLevelValue"
                            class="input is-small"
                            type="number"
                            min="1"
                            placeholder="Level"
                            @input="$emit('input', $event.target.value)">
                    </div>
                    <div class="control">
                        <a
                            class="button is-small is-success"
                            @click="$emit('add-level', currentLevelValue)">
                            <i
                                class="mdi mdi-plus"
                                aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-block has-background-white">
            <vue-multiselect
                :value="selectedLevel"
                :options="levels"
                class="vue-multiselect"
                @input="$emit('input', $event.target.value)" />
        </div>
    </div>
</template>
<script>
import VueMultiselect from "vue-multiselect";

export default {
    name: "LevelSelectorInput",
    components: {VueMultiselect},
    props: {
        selectedLevel:{
            validator: prop => typeof prop === "number" || prop === null,
            required: true,
        },
        currentLevelValue: {
            type: Number,
            required: true,
        },
        levels: {
            type: Array,
            required: true,
        }
    }
};
</script>
<style scoped>
    .is-fullwidth {
        width: 100%;
    }
</style>
