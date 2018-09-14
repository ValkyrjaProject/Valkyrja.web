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
                                :disabled="!publicTypeIsSelected()"
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
                            :disabled="!publicTypeIsSelected()"
                            class="button is-info"
                            @click="addPublicGroup()">
                            <i
                                class="mdi mdi-plus"
                                aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-block">
                <div class="control field">
                    <div class="control is-expanded">
                        <div class="is-fullwidth">
                            <input
                                v-model="groupName"
                                :disabled="!publicGroupIsSelected"
                                type="text"
                                class="input"
                                placeholder="Group name">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-block">
                <div class="control field">
                    <div class="control is-expanded">
                        <div class="is-fullwidth">
                            <label>
                                Number of roles from this group that the user can take
                                <input
                                    v-model="roleLimit"
                                    :disabled="!publicGroupIsSelected"
                                    type="number"
                                    class="input"
                                    placeholder="Role limit">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        {{ this.publicGroups }}
    </div>
</template>

<script>
import PublicGroup from "../../../../../models/PublicGroup";
import {NoGroup} from "../../../../../store/modules/RoleSelector";

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
        types() {
            return this.state.types;
        },
        selectedType() {
            return this.state.selectedType;
        },
        publicGroups() {
            return this.$store.getters["roleSelector/publicGroups"];
        },
        sortedPublicGroups() {
            // Clone list to sort it
            let groups = [NoGroup,...this.publicGroups];
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
        groupName: {
            get() {
                if (this.objectIsPublicGroup(this.selectedPublicGroup)) {
                    return this.selectedPublicGroup.name;
                }
            },
            set(name) {
                this.$store.dispatch("roleSelector/changeGroupName", name);
            }
        },
        roleLimit: {
            get() {
                if (this.objectIsPublicGroup(this.selectedPublicGroup)) {
                    return this.selectedPublicGroup.role_limit;
                }
            },
            set(limit) {
                this.$store.dispatch("roleSelector/changeRoleLimit", limit);
            },
        },
        publicGroupIsSelected() {
            return !!(this.objectIsPublicGroup(this.selectedPublicGroup) && this.publicTypeIsSelected());

        },
    },
    methods: {
        addPublicGroup() {
            if (this.isActive && this.publicTypeIsSelected()) {
                let start = 1;
                this.publicGroups.forEach((group, index) => {
                    if (parseInt(group.id) === (parseInt(index) + 1)) {
                        start = parseInt(group.id) + 1;
                        return true;
                    }
                });
                const group = PublicGroup.createInstance(start);
                this.$store.dispatch("roleSelector/addPublicGroup", group);
                this.$store.dispatch("roleSelector/selectedPublicGroup", group);
            }
        },
        objectIsPublicGroup(object) {
            return object instanceof PublicGroup;
        },
        publicTypeIsSelected(){
            return this.selectedType === this.types.Public;
        },
    },
};
</script>

