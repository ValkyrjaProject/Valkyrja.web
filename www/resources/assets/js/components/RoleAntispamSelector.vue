<template>
    <div>
        <list-selector :value="listValues"
                       @add="addRole($event)"
                       @remove="removeRole($event)"
                       available-label="Available roles"
                       added-label="Ignored roles"></list-selector>
        <slot :added="added"></slot>
    </div>
</template>

<script>
    import ListSelector from '../components/ListSelector.vue'
    import {updateItem, addItem, removeItem} from '../vuex/actions'

    export default {
        name: "RoleAntispamSelector",
        components: {
            ListSelector
        },
        data: function () {
            return {
                addedValues: this.value
            }
        },
        computed: {
            available() {
                return this.$store.state.roles
            },
            added() {
                return this.$store.state.itemModifier.roles.itemsList;
            },
            listValues() {
                return {
                    available: this.available.filter(r => {
                        return (this.added.filter(t => {
                            return t[['roleid']] === r.id &&
                                    t[['antispam_ignored']] === true
                        }).length === 0);
                    }),
                    added: this.available.filter(r => {
                        return !(this.added.filter(t => {
                            return t[['roleid']] === r.id &&
                                    t[['antispam_ignored']] === true
                        }).length === 0);
                    }),
                }
            },
        },
        methods: {
            addRole(role) {
                let roles = this.added.filter(r => r[['roleid']] === role.id);
                if (roles.length > 0) {
                    let roleToChange = roles[0];
                    this.$store.dispatch('updateItem', {
                        data: true,
                        key: 'antispam_ignored',
                        formName: 'roles',
                        obj: roleToChange,
                    });
                }
                else {
                    let newRole = {
                        roleid: role.id,
                        antispam_ignored: true,
                        public_id: "0",
                        permission_level: "0"
                    };
                    this.$store.dispatch('addItem', {
                        item: newRole,
                        formName: 'roles',
                    });
                }
            },
            removeRole(role) {
                const roleToChange = this.added.filter(r => r[['roleid']] === role.id)[0];
                this.$store.dispatch('updateItem', {
                    data: false,
                    key: 'antispam_ignored',
                    formName: 'roles',
                    obj: roleToChange,
                });
            },
        }
    }
</script>