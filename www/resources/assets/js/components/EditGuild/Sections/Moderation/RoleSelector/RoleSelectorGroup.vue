<template>
    <div>
        <nav class="panel panel-parent">
            <p class="panel-heading">
                {{ title }}
            </p>
            <div class="panel-block">
                <div class="control field has-addons">
                    <div class="control is-expanded">
                        <div class="select is-fullwidth">
                            <select
                                :title="title"
                                v-model="selectedPublicGroup"
                                name="role-group">
                                <option
                                    v-for="group in sortedPublicGroups"
                                    :key="group.id"
                                    :value="group">{{ group.toString() }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="control">
                        <a
                            class="button is-info"
                            @click="addPublicGroup()">
                            <i
                                class="mdi mdi-plus"
                                aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
import PublicGroup from "../../../../../models/PublicGroup";

export default {
    name: "RoleSelectorGroup",
    props: {
        title: {
            type: String,
            required: true,
        },
        isActive: {
            type: Boolean,
            required: false,
            default: true,
        },
    },
    computed: {
        state() {
            return this.$store.state.roleSelector;
        },
        publicGroups() {
            return this.state.publicGroups;
        },
        sortedPublicGroups() {
            let groups = [...this.publicGroups];
            return groups.sort((a, b) => {
                return a.id - b.id;
            });
        },
        selectedPublicGroup: {
            get() {
                return this.state.selectedPublicGroup;
            },
            set(group) {
                this.$store.dispatch("roleSelector/selectedPublicGroup", group);
            },
        },
    },
    methods: {
        addPublicGroup() {
            if (this.isActive) {
                let start = 1;
                this.publicGroups.forEach((group, index) => {
                    if (parseInt(group.value) === index) {
                        start = parseInt(group.value) + 1;
                        return true;
                    }
                });
                const group = PublicGroup.createInstance(start);
                this.$store.dispatch("roleSelector/addPublicGroup", group);
                this.$store.dispatch("roleSelector/selectedPublicGroup", group);
            }
        },
    },
};
</script>

