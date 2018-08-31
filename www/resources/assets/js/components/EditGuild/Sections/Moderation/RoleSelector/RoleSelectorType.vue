<template>
    <div>
        <nav class="panel panel-parent">
            <p class="panel-heading">
                {{ title }}
            </p>
            <div class="panel-block control">
                <div class="select is-fullwidth">
                    <select 
                        v-model="selectedType"
                        name="role-type"
                        title="Public role">
                        <option 
                            v-for="(level, name) in types" 
                            :value="level">{{ name }}</option>
                    </select>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    name: "RoleSelectorType",
    props: {
        title: {
            type: String,
            required: true
        }
    },
    computed: {
        state() {
            return this.$store.state.roleSelector;
        },
        selectedType: {
            get() {
                return this.state.selectedType;
            },
            set(value) {
                this.$store.dispatch("roleSelector/changeSelectedType", value);
            }
        },
        types() {
            return this.state.types;
        },
    }
};
</script>

<style scoped>

</style>