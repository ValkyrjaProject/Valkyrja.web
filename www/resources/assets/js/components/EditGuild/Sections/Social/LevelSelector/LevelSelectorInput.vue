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
                            @click="addLevel(currentLevelValue)">
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
                v-model="selectedLevel"
                :custom-label="levelName"
                placeholder="Select level"
                class="vue-multiselect"/>
        </div>
    </div>
</template>
<script>
import VueMultiselect from "vue-multiselect";

export default {
    name: "LevelSelectorInput",
    components: {VueMultiselect},
    data() {
        return {
            currentLevelValue: 1
        };
    },
    computed: {
        levels() {
            return this.$store.state.levelSelector.levels;
        },
        selectedLevel: {
            get() {
                return this.$store.state.levelSelector.selectedLevel;
            },
            set(level) {
                this.$store.dispatch("levelSelector/changeSelectedLevel", level);
            }
        }
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
        },
        addLevel(level) {
            level = parseInt(level);
            if (this.levels.indexOf(level) === -1) {
                this.$store.dispatch("levelSelector/addLevel", level);
                this.selectedLevel = level;
            }
        }
    }
};
</script>
<style scoped>
    .is-fullwidth {
        width: 100%;
    }
</style>
