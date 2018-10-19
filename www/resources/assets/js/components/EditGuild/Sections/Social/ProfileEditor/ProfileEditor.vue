<template>
    <div class="box has-background-white-bis">
        <div class="columns">
            <panel-list
                :value="profiles"
                :add-button="true"
                list-item="PanelListItemRemovable"
                class="column is-two-fifths options"
                title="Profiles"
                @input="selectedProfile = $event"
                @add="addProfile()"
            />
            <div class="column">
                <div class="panel panel-parent">
                    <nav class="panel-heading">
                        Selected profile
                    </nav>
                    <div class="panel-block">
                        <label>
                            <b>Option</b> - Unique parameter used to set the profile field (example: <code>-b</code>)
                            <input
                                v-model="option"
                                :disabled="hasSelectedProfile()"
                                type="text"
                                class="input">
                        </label>
                    </div>
                    <div class="panel-block">
                        <label>
                            <b>Alternative option</b> - Long version of the above option (example: <code>--bike</code>)
                            <input
                                v-model="option_alt"
                                :disabled="hasSelectedProfile()"
                                type="text"
                                class="input">
                        </label>
                    </div>
                    <div class="panel-block">
                        <label>
                            <b>Label</b> - Field title visible in the profile up to 250 characters (example: <code>Mountain Bike</code>)
                            <input
                                v-model="label"
                                :disabled="hasSelectedProfile()"
                                type="text"
                                class="input">
                        </label>
                    </div>
                    <div class="panel-block">
                        <label>
                            <b>Property Order</b> - The determines the order in which the fields are displayed (example: <code>1</code>)
                            <input
                                v-model="property_order"
                                :disabled="hasSelectedProfile()"
                                type="number"
                                class="input">
                        </label>
                    </div>
                    <div class="panel-block">
                        <input
                            id="profile__inline"
                            v-model="inline"
                            :disabled="hasSelectedProfile()"
                            :true-value="1"
                            :false-value="0"
                            type="checkbox"
                            class="switch is-success">
                        <label for="profile__inline">
                            <b>Inline</b> - Inline fields are in multiple columns. Many inline options may cause unexpected formatting!
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PanelList from "../../../../shared/structure/PanelList/PanelList";

export default {
    name: "ProfileEditor",
    components: {
        PanelList,
    },
    computed: {
        profiles() {
            return this.$store.getters["profileEditor/profiles"];
        },
        selectedProfile: {
            get() {
                return this.$store.state.profileEditor.selectedProfile;
            },
            set(profile) {
                this.$store.dispatch("profileEditor/changeField", profile);
            }
        },
        option: {
            get() {
                return this.selectedProfile ? this.selectedProfile.option : "";
            },
            set(option) {
                this.$store.dispatch("profileEditor/changeField", {
                    field: "option",
                    value: option
                });
            }
        },
        option_alt: {
            get() {
                return this.selectedProfile ? this.selectedProfile.option_alt : "";
            },
            set(option_alt) {
                this.$store.dispatch("profileEditor/changeField", {
                    field: "option_alt",
                    value: option_alt
                });
            }
        },
        label: {
            get() {
                return this.selectedProfile ? this.selectedProfile.label : "";
            },
            set(label) {
                this.$store.dispatch("profileEditor/changeField", {
                    field: "label",
                    value: label
                });
            }
        },
        property_order: {
            get() {
                return this.selectedProfile ? this.selectedProfile.property_order : "";
            },
            set(property_order) {
                this.$store.dispatch("profileEditor/changeField", {
                    field: "property_order",
                    value: property_order
                });
            }
        },
        inline: {
            get() {
                return this.selectedProfile ? this.selectedProfile.inline : "";
            },
            set(inline) {
                this.$store.dispatch("profileEditor/changeField", {
                    field: "inline",
                    value: inline
                });
            }
        },
    },
    methods: {
        hasSelectedProfile() {
            return this.selectedProfile === null || this.selectedProfile === undefined;
        },
        addProfile() {
            this.$store.dispatch("profileEditor/addProfile", Profile.newInstance());
        },
    }
};
</script>

<style scoped>
    .options.column {
        min-height: 310px;
    }
    .options.column >>> .panel:nth-child(2) {
        min-height: inherit !important;
    }
</style>
