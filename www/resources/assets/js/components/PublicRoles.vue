<template>
    <div class="inputList loadComponent">
        <div v-if="$isLoading(this.formName)" class="loading">
            <span>{{loadingText}}</span>
        </div>
        <item-modifier :form-name="formName"
                       list-name="Public Roles"
                       :new-item-layout="addPublicRolesTemplate"
                       item-layout-primary-key="ID">
            <template scope="props">
                <div class="from-group"
                     :class="{'has-danger': isDuplicate(props.activeItem) || props.activeItem.ID.length === 0 || hasWhitespace(props.activeItem.ID) || isBotwinderCommand(props.activeItem)}">
                    <label class="form-control-label">
                        <b>Id</b> - Unique command identifier, prefix+this is what you will use to run your command.
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">{{ CommandCharacter }}</span>
                            <input class="form-control" command-name="ID" :value="props.activeItem.ID"
                                   @input="updateActiveItemData">
                        </div>
                    </label>
                    <div class="form-control-feedback" v-if="isDuplicate(props.activeItem)">
                        Id must be unique.
                    </div>
                    <div class="form-control-feedback" v-if="props.activeItem.ID.length === 0">
                        Id cannot be empty.
                    </div>
                    <div class="form-control-feedback" v-if="hasWhitespace(props.activeItem.ID)">
                        Id cannot contain whitespaces.
                    </div>
                </div>
                <div class="form-group">
                    <b>Whitelisted roles</b> - Only these roles can use the command. Leave empty to be unrestricted.
                    <id-selector :value="roles"
                                 @add="addRole($event)"
                                 @remove="removeRole($event)"
                                 init-id-type="Roles"
                                 :init-form-name="formName"
                                 :hide-inputs="true"
                                 :state-index="activeItemIndex"
                                 :use-store="false"></id-selector>
                </div>
            </template>
        </item-modifier>
    </div>
</template>

<script>
    import ItemModifier from './ItemModifier.vue'
    import IdSelector from './IdSelector.vue'
    import {
        updateActiveItemData
    } from '../vuex/actions'
    import listItems from '../mixins/listItems'

    export default {
        mixins: [listItems],
        props: {
            formName: {
                required: true
            }
        },
        data: function() {
            return {
                itemLayoutPrimaryKey: 'ID',
                loadingText: "Loading config please wait!",
                roleName: 'RoleIDs'
            }
        },
        components: {
            ItemModifier,
            IdSelector
        },
        created() {
            this.$startLoading(this.formName);
            this.$store.dispatch('updateItemModifier', this.formName)
                .then(() => {
                    this.$endLoading(this.formName);
                })
                .catch(() => {
                    this.loadingText = 'Could not get config values.';
                });
        },
        computed: {
            CommandCharacter() {
                return this.$store.state.CommandCharacter;
            },
            addPublicRolesTemplate() {
                return {
                    ID: 'group',
                    RoleIDs: []
                };
            },
        },
        methods: {
            hasWhitespace(input) {
                return /^.*\s.*$/.test(input)
            },
            itemIsValid(command) {
                return !(command.ID.length === 0
                    || this.hasWhitespace(command.ID));

            }
        }
    }
</script>