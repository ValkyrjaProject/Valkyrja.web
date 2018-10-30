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
                                    class="input is-small"
                                    type="number"
                                    min="1"
                                    placeholder="Level">
                            </div>
                            <div class="control">
                                <a class="button is-small is-success">
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
                        :options="[]"
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
