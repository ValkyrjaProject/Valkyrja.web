<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <div class="column is-one-third">
                <level-selector-input
                    :levels="levels"
                    :selected-level="selectedLevel"
                    @add-level="addLevel" />
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
import LevelSelectorInput from "./LevelSelectorInput";
import {Level} from "../../../../../models/Level";

export default {
    name: "LevelSelector",
    components: {
        LevelSelectorInput,
        PanelList,
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
                    level: 0
                });
            }
        }
    },
    methods: {
        addLevel(level) {
            console.log("level", level);

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
