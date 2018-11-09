<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <div class="column is-one-third">
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
                                    v-model="currentLevelValue"
                                    class="input is-small"
                                    type="number"
                                    min="1"
                                    placeholder="Level">
                            </div>
                            <div class="control">
                                <a
                                    class="button is-small is-success"
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
                        v-model="selectedLevel"
                        :options="levels"
                        class="vue-multiselect"/>
                </div>
            </div>
            <div class="column is-one-third">
                <panel-list
                    v-model="availableRoles"
                    class="is-fullwidth"
                    title="Available roles"
                />
            </div>
            <div class="column is-one-third">
                <panel-list
                    v-model="addedRoles"
                    class="is-fullwidth"
                    title="Roles added to level"
                />
            </div>
        </div>
    </div>
</template>

<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";
import VueMultiselect from "vue-multiselect";

export default {
    name: "LevelSelector",
    components: {
        PanelList,
        VueMultiselect,
    },
    data() {
        return {
            currentLevelValue: 0
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
        },
        availableRoles: {
            get() {
                return this.$store.getters["levelSelector/availableRoles"];
            },
            set(role) {
                if (!this.selectedLevel) return;
                this.$store.dispatch("levelSelector/changeRoleLevel", {
                    role,
                    level: this.selectedLevel,
                });
            }
        },
        addedRoles: {
            get() {
                return this.$store.getters["levelSelector/addedRoles"];
            },
            set(role) {
                this.$store.dispatch("levelSelector/changeLevel", {
                    role,
                    level: "0"
                });
            }
        }
    },
    methods: {
        addLevel(level) {
            if (this.levels.indexOf(level) === -1) {
                this.$store.dispatch("levelSelector/addLevel", level);
                this.selectedLevel = level;
            }
        }
    },
};
</script>

<style scoped>
    .is-fullwidth {
        width: 100%;
    }
</style>
