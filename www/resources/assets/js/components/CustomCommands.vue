<template>
    <div class="customCommands loadComponent">
        <div v-if="isLoading" class="loading">
            <span>Loading config please wait!</span>
        </div>
        <div class="listContainer">
            <h2>Custom commands</h2>
            <div class="selectList tallerList">
                <div class="listItem listItemGroup input-group" v-for="(command, commandKey, index) in customCommands" :class="{'has-danger': isDuplicate(command) || command.ID.length === 0 || hasWhitespace(command.ID) || isBotwinderCommand(command) || command.Response.length === 0}">
                    <div class="input-group-addon" @click="removeCommand(command)">✕</div>
                    <span class="itemLeft btn" @click="setActiveCommand(command)">{{command.ID.trim().substring(0, 15)}}</span>
                    <span v-for="(commandType, commandTypeKey) in command" v-if="commandType !== null">
                        <span v-if="commandTypeKey === 'RoleWhitelist'">
                            <span v-if="commandType.length == 0">
                                <input type="hidden" :name="inputName(commandTypeKey, command)" value="">
                            </span>
                            <span v-else>
                                <input v-for="(role, roleKey) in commandType" type="hidden" :name="roleName(commandTypeKey, command)" :value="role">
                            </span>
                        </span>
                        <span v-else-if="commandTypeKey === 'DeleteRequest'">
                            <input type="hidden" :name="inputName(commandTypeKey, command)" :value="commandType || false">
                        </span>
                        <input v-else type="hidden" :name="inputName(commandTypeKey, command)" :value="commandType || ''">
                    </span>
                </div>
            </div>
            <a class="listItem centerText" @click="newCommand()">
                +
            </a>
        </div>
        <div class="listContainer">
            <div v-if="activeCommand != null">
                <div class="from-group" :class="{'has-danger': isDuplicate(activeCommand) || activeCommand.ID.length === 0 || hasWhitespace(activeCommand.ID) || isBotwinderCommand(activeCommand)}">
                    <label class="form-control-label">
                        <b>Id</b> - Unique command identifier, prefix+this is what you will use to run your command.
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">{{ CommandCharacter }}</span>
                            <input class="form-control" type="text" command-name="ID" :value="activeCommand.ID" @input="updateActiveCommand">
                        </div>
                    </label>
                    <div class="form-control-feedback" v-if="isDuplicate(activeCommand)">Id must be unique.</div>
                    <div class="form-control-feedback" v-if="isBotwinderCommand(activeCommand)">Id cannot be the same as a Botwinder command.</div>
                    <div class="form-control-feedback" v-if="activeCommand.ID.length === 0">Id cannot be empty.</div>
                    <div class="form-control-feedback" v-if="hasWhitespace(activeCommand.ID)">Id cannot contain whitespaces.</div>
                </div>
                <div class="from-group" :class="activeCommand.Response.length === 0 ? 'has-danger' : ''">
                    <label class="form-control-label">
                        <b>Response</b>
                        <textarea class="form-control" command-name="Response" :value="activeCommand.Response" @input="updateActiveCommand"></textarea>
                    </label>
                    <div class="form-control-feedback" v-if="activeCommand.Response.length === 0">Response is required</div>
                </div>
                <div class="form-group">
                    <label>
                        <b>Description</b>
                        <input class="form-control" type="text" command-name="Description" :value="activeCommand.Description" @input="updateActiveCommand">
                    </label>
                    <b>Whitelisted roles</b> - Only these roles can use the command. Leave empty to be unrestricted.
                    <id-selector init-id-type="Roles" init-form-name="CustomCommands" :hide-inputs="true" :state-index="activeCommandIndex"></id-selector>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" v-model="deleteRequest">
                        <b>Delete request</b> - Delete the message issuing the command?
                    </label>
                </div>
            </div>
            <div v-else>Nothing selected</div>
        </div>
    </div>
</template>

<script>
    import IdSelector from '../components/IdSelector.vue'
    import {updateActiveCustomCommandData, addCustomCommand, updateCommandCharacter, updateActiveCustomCommand, updateState} from '../vuex/actions'

    export default {
        props: {
            formName: {
                required: true
            }
        },
        data: function () {
            return {
                isLoading: true
            };
        },
        components: {
            IdSelector
        },
        created () {
            this.$store.dispatch('updateCustomCommands', this.formName)
                .then(() => {
                    this.isLoading = false;
                });
        },
        computed: {
            activeCommandIndex () {
                return this.customCommands.indexOf(this.activeCommand);
            },
            customCommands () {
                let commands = this.$store.state.data.CustomCommands.commandsList;
                if (commands === null) {
                    return ''
                }
                return commands;
            },
            activeCommand () {
                return this.$store.state.data.CustomCommands.activeCommand
            },
            CommandCharacter () {
                return this.$store.state.commandCharacter;
            },
            botwinderCommands () {
                return this.$store.state.botwinderCommands;
            },
            deleteRequest: {
                get () {
                    return this.$store.state.data.CustomCommands.activeCommand.DeleteRequest
                },
                set (value) {
                    this.$store.dispatch('updateActiveCustomCommandData',
                        {
                            key: 'DeleteRequest',
                            data: value
                        })
                }
            }
        },
        methods: {
            setActiveCommand (command) {
                this.$store.dispatch('updateActiveCustomCommand', command);
            },
            newCommand () {
                const command = {
                    ID: 'command' + this.customCommands.length,
                    Response: 'Response',
                    Description: '',
                    RoleWhitelist: [],
                    DeleteRequest: false
                };
                this.$store.dispatch('addCustomCommand', command);
                this.setActiveCommand(command);
            },
            removeCommand (command) {
                this.$store.dispatch('removeCustomCommand', command);
                if (command === this.activeCommand) {
                    this.setActiveCommand()
                }
            },
            inputName (attribute, command) {
                return this.formName + '[' + this.customCommands.indexOf(command) + ']' + '[' + attribute + ']'
            },
            roleName (attribute, command) {
                return this.inputName(attribute, command) + '[]';
            },
            updateActiveCommand (e) {
                // Only allow certain character for ID
                this.$store.dispatch('updateActiveCustomCommandData',
                    {
                        key: e.target.getAttribute('command-name'),
                        data: e.target.value
                    })
            },
            isDuplicate (check) {
                // Check if command already exists
                for (let command of this.customCommands) {
                    if (command.ID === check.ID && this.customCommands.indexOf(command) !== this.customCommands.indexOf(check)) {
                        return true;
                    }
                }
                return false;
            },
            isBotwinderCommand (check) {
                // Check if command already exists
                for (let id of this.botwinderCommands) {
                    if (id === check.ID) {
                        return true;
                    }
                }
                return false;
            },
            hasWhitespace (input) {
                return /^.*\s.*$/.test(input)
            }
        }
    }
</script>