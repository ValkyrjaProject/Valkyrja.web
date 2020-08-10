<template>
    <div class="customCommands loadComponent">
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
                        Id cannot be the same as a Valkyrja command.
                    </div>
                    <div class="form-control-feedback" v-if="props.activeItem.commandid.length === 0">Id cannot be empty.</div>
                    <div class="form-control-feedback" v-if="hasWhitespace(props.activeItem.commandid)">
                        Id cannot contain whitespaces.
                    </div>
                </div>
                <div class="from-group" :class="{'has-danger': props.activeItem.response.length === 0}">
                    <label class="form-control-label">
                        <b>Response message</b> - You can use the following:
                        <ul>
                            <li><code>{{sender}}</code> or <code>{{mentioned}}</code> anywhere - mentions the sender or the mentioned people.</li>
                            <li><code>&lt;pm&gt;</code> in the beginning - PM the mentioned people.</li>
                            <li><code>&lt;pm-sender&gt;</code> in the beginning - PM the one who issued the command.</li>
                            <li>You can use RNG to choose from a list of responses using: <code>&lt;|&gt;reply1&lt;|&gt;reply2&lt;|&gt;</code></li>
                            <li>You can send embeds instead using the full <code>!embed</code> command syntax - supports all the above options as well.</li>
                        </ul>
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
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" style="margin-right: 5px" command-name="mentions_enabled" :checked="props.activeItem.mentions_enabled"
                               @input="updateActiveItemData"
                               :true-value="1"
                               :false-value="0">
                        Allow role mentions - these have to be entered using Discord ID format <code>&lt;@&amp;roleId&gt;</code> (or <code>&lt;@userId&gt;</code> etc)
                    </label>
                </div>
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
        computed: {
            command_prefix() {
                return this.$store.state.command_prefix;
            },
            botwinderCommands() {
                return this.$store.state.botwinderCommands;
            },
            addCustomCommandTemplate() {
                return {
                    commandid: 'command',
                    response: 'Response',
                    description: '',
                    mentions_enabled: false
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
