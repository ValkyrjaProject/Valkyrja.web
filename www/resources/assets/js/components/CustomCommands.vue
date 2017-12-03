<template>
    <div class="customCommands loadComponent">
        <div v-if="$isLoading(this.formName)" class="loading">
            <span>{{loadingText}}</span>
        </div>
        <item-modifier :form-name="formName"
                       list-name="Custom Commands"
                       :new-item-layout="addCustomCommandTemplate"
                       item-layout-primary-key="commandid">
            <template slot-scope="props">
                <div class="from-group"
                     :class="{'has-danger': isDuplicate(props.activeItem) || props.activeItem.commandid.length === 0 || hasWhitespace(props.activeItem.commandid) || isBotwinderCommand(props.activeItem)}">
                    <label class="form-control-label">
                        <b>Id</b> - Unique command identifier, prefix+this is what you will use to run your command.
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">{{ command_prefix }}</span>
                            <input class="form-control" command-name="commandid" :value="props.activeItem.commandid"
                                   @input="updateActiveItemData">
                        </div>
                    </label>
                    <div class="form-control-feedback" v-if="isDuplicate(props.activeItem)">Id must be unique.</div>
                    <div class="form-control-feedback" v-if="isBotwinderCommand(props.activeItem)">
                        Id cannot be the same as a Botwinder command.
                    </div>
                    <div class="form-control-feedback" v-if="props.activeItem.commandid.length === 0">Id cannot be empty.</div>
                    <div class="form-control-feedback" v-if="hasWhitespace(props.activeItem.commandid)">
                        Id cannot contain whitespaces.
                    </div>
                </div>
                <div class="from-group" :class="{'has-danger': props.activeItem.response.length === 0}">
                    <label class="form-control-label">
                        <b>Response message</b> - You can use <code v-pre>{{sender}}</code> or <code
                            v-pre>{{mentioned}}</code> variables.
                        <textarea class="form-control" command-name="response" :value="props.activeItem.response"
                                  @input="updateActiveItemData"></textarea>
                    </label>
                    <div class="form-control-feedback" v-if="props.activeItem.response.length === 0">
                        Response is required
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        <b>Description</b> - the <code>{{ command_prefix }}help</code> message.
                        <input class="form-control" command-name="description" :value="props.activeItem.description"
                               @input="updateActiveItemData">
                    </label>
                    <!--<b>Whitelisted roles</b> - Only these roles can use the command. Leave empty to be unrestricted.
                    <id-selector :value="roles"
                                 @add="addRole($event)"
                                 @remove="removeRole($event)"
                                 init-id-type="Roles"
                                 :init-form-name="formName"
                                 :hide-inputs="true"
                                 :state-index="activeItemIndex"
                                 :use-store="false"></id-selector>-->
                </div>
                <!--<div class="form-group">
                    <label>
                        <input type="checkbox" v-model="deleteRequest">
                        <b>Delete request</b> - Delete the message issuing the command?
                    </label>
                </div>-->
            </template>
        </item-modifier>
    </div>
</template>

<script>
    import ItemModifier from './ItemModifier.vue'
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
                itemLayoutPrimaryKey: 'commandid',
                loadingText: "Loading config please wait!",
                roleName: 'RoleWhitelist'
            }
        },
        components: {
            ItemModifier,
        },
        /*created() {
            this.$startLoading(this.formName);
            this.$store.dispatch('updateItemModifier', this.formName)
                .then(() => {
                    this.$endLoading(this.formName);
                })
                .catch(() => {
                    this.loadingText = 'Could not get config values.';
                });
        },*/
        computed: {
            command_prefix() {
                return this.$store.state.command_prefix;
            },
            botwinderCommands() {
                return this.$store.state.botwinderCommands;
            },
            /*deleteRequest: {
                get() {
                    return this.$store.state.itemModifier[this.formName].activeItem.DeleteRequest
                },
                set(value) {
                    this.$store.dispatch('updateActiveItemData',
                        {
                            key: 'DeleteRequest',
                            formName: this.formName,
                            data: value
                        })
                }
            },*/
            addCustomCommandTemplate() {
                return {
                    commandid: 'command',
                    response: 'Response',
                    description: ''
                };
            },
        },
        methods: {
            isBotwinderCommand(check) {
                // Check if command already exists
                for (let id of this.botwinderCommands) {
                    if (id === check.commandid) {
                        return true;
                    }
                }
                return false;
            },
            hasWhitespace(input) {
                return /^.*\s.*$/.test(input)
            },
            itemIsValid(command) {
                return !(command.commandid.length === 0
                    || this.hasWhitespace(command.commandid)
                    || this.isBotwinderCommand(command)
                    || command.response.length === 0);
            }
        }
    }
</script>