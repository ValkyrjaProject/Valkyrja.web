<template>
    <div class="box has-background-white-bis">
        <div class="tile is-ancestor">
            <div class="tile is-parent">
                <div class="tile">
                    <panel-list
                        v-model="availableRoles"
                        class="is-fullwidth"
                        title="Available roles"
                    />
                </div>
            </div>
            <div class="tile is-parent is-vertical">
                <div class="tile is-marginless is-vertical">
                    <nav class="panel is-marginless panel-parent">
                        <p class="panel-heading">
                            Roles added to level
                        </p>
                    </nav>
                    <div class="panel panel-block has-background-white">
                        <vue-multiselect
                                :options="[]"
                                class="vue-multiselect"/>
                    </div>
                </div>
                <div class="tile is-child">
                    <panel-list
                        v-model="availableRoles"
                        class="is-fullwidth"
                    />
                </div>
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
    data: function() {
        return {
            selectedLevel: null,
        };
    },
    computed: {
        availableRoles: {
            get() {
                return this.$store.getters["levelSelector/availableRoles"];
            },
            set(role) {
                if (!this.selectedLevel) return;
                this.$store.dispatch("levelSelector/changeLevel", {
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
    }
};
</script>

<style scoped>
    .is-fullwidth {
        width: 100%;
    }
</style>
