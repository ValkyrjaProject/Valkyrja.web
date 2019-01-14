<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <div class="column is-one-third">
                <level-selector-input/>
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
        selectedLevel() {
            return this.$store.state.levelSelector.selectedLevel;
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
                this.$store.dispatch("levelSelector/changeRoleLevel", {
                    role,
                    level: 0
                });
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
