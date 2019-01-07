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
                    <div class="control">
                        <a class="button is-static">
                            Level
                        </a>
                    </div>
                    <div class="control is-expanded">
                        <input
                            v-model="currentLevelValue"
                            class="input"
                            type="number"
                            min="1"
                            placeholder="Level">
                    </div>
                    <div class="control">
                        <a
                            class="button is-success"
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
                :options="levels"
                :value="selectedLevel"
                :custom-label="levelName"
                placeholder="Select level"
                class="vue-multiselect"
                @input="$emit('input', $event)" />
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
        levels: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            currentLevelValue: 0
        };
    },
    watch: {
        selectedLevel(newValue, oldValue) {
            console.log("new value", newValue, oldValue);
        }
    },
    methods: {
        name(value) {
            console.log(value);
        },
        levelName (value) {
            return `Level ${value}`;
        }
    },
};
</script>
<style scoped>
    .is-fullwidth {
        width: 100%;
    }
</style>
