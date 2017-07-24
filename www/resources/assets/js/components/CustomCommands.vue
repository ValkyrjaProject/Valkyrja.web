<template>
    <div class="customCommands loadComponent">
        <div v-if="$isLoading(this.formName)" class="loading">
            <span>Loading config please wait!</span>
        </div>
        <div class="listContainer">
            <h2>Custom commands</h2>
            <list-container :value="customCommands"
                            @input="setActiveCommand($event)"
                            @click="removeCommand($event)"
                            @add="newCommand()"
                            :hide-form="true"
                            :include-search="true"
                            :can-add="true"
                            list-type="doubleInput"
                            show-attribute="ID"
                            form-name="CustomCommands"
                            class="tallerList"></list-container>
        </div>
        <div class="listContainer">
            <div v-if="activeCommand != null">
                <div class="from-group"
                     :class="{'has-danger': isDuplicate(activeCommand) || activeCommand.ID.length === 0 || hasWhitespace(activeCommand.ID) || isBotwinderCommand(activeCommand)}">
                    <label class="form-control-label">
                        <b>Id</b> - Unique command identifier, prefix+this is what you will use to run your command.
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">{{ CommandCharacter }}</span>
                            <input class="form-control" command-name="ID" :value="activeCommand.ID"
                                   @input="updateActiveCommand">
                        </div>
                    </label>
                    <div class="form-control-feedback" v-if="isDuplicate(activeCommand)">Id must be unique.</div>
                    <div class="form-control-feedback" v-if="isBotwinderCommand(activeCommand)">
                        Id cannot be the same as a Botwinder command.
                    </div>
                    <div class="form-control-feedback" v-if="activeCommand.ID.length === 0">Id cannot be empty.</div>
                    <div class="form-control-feedback" v-if="hasWhitespace(activeCommand.ID)">
                        Id cannot contain whitespaces.
                    </div>
                </div>
                <div class="from-group" :class="{'has-danger': activeCommand.Response.length === 0}">
                    <label class="form-control-label">
                        <b>Response message</b> - You can use <code v-pre>{{sender}}</code> or <code v-pre>{{mentioned}}</code> variables.
                        <textarea class="form-control" command-name="Response" :value="activeCommand.Response"
                                  @input="updateActiveCommand"></textarea>
                    </label>
                    <div class="form-control-feedback" v-if="activeCommand.Response.length === 0">Response is required
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        <b>Description</b> - the <code>{{CommandCharacter}}help</code> message.
                        <input class="form-control" command-name="Description" :value="activeCommand.Description"
                               @input="updateActiveCommand">
                    </label>
                    <b>Whitelisted roles</b> - Only these roles can use the command. Leave empty to be unrestricted.
                    <id-selector :value="roles"
                                 @add="addRoleWhitelist($event)"
                                 @remove="removeRoleWhitelist($event)"
                                 init-id-type="Roles"
                                 init-form-name="CustomCommands"
                                 :hide-inputs="true"
                                 :state-index="activeCommandIndex"
                                 :use-store="false"></id-selector>
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
        <span v-for="command in customCommands">
            <span v-for="(commandType, commandTypeKey) in command" v-if="commandType !== null">
                <span v-if="commandTypeKey === 'RoleWhitelist'">
                    <span v-if="commandType.length == 0">
                        <input type="hidden" :name="inputName(commandTypeKey, command)" value="">
                    </span>
                    <span v-else>
                        <input v-for="(role, roleKey) in commandType" type="hidden"
                               :name="roleName(commandTypeKey, command)" :value="role">
                    </span>
                </span>
                <span v-else-if="commandTypeKey === 'DeleteRequest'">
                    <input type="hidden" :name="inputName(commandTypeKey, command)" :value="commandType || false">
                </span>
                <input v-else type="hidden" :name="inputName(commandTypeKey, command)" :value="commandType || ''">
            </span>
        </span>
    </div>
</template>

<script>
    import ListContainer from '../components/ListContainer.vue'
    import IdSelector from '../components/IdSelector.vue'
    import {
        updateActiveCustomCommandData,
        addCustomCommand,
        updateCommandCharacter,
        updateActiveCustomCommand
    } from '../vuex/actions'

    export default {
        props: {
            formName: {
                required: true
            }
        },
        components: {
            IdSelector,
            ListContainer
        },
        created() {
            this.$startLoading(this.formName);
            this.$store.dispatch('updateCustomCommands', this.formName)
                .then(() => {
                    this.$endLoading(this.formName);
                    this.setActiveCommand(this.customCommands[0]);
                });
        },
        computed: {
            activeCommandIndex() {
                return this.customCommands.indexOf(this.activeCommand);
            },
            customCommands() {
                let commands = this.$store.state.data.CustomCommands.commandsList;
                if (commands === null) {
                    return []
                }
                return commands;
            },
            activeCommand() {
                return this.$store.state.data.CustomCommands.activeCommand
            },
            CommandCharacter() {
                return this.$store.state.CommandCharacter;
            },
            botwinderCommands() {
                return this.$store.state.botwinderCommands;
            },
            deleteRequest: {
                get() {
                    return this.$store.state.data.CustomCommands.activeCommand.DeleteRequest
                },
                set(value) {
                    this.$store.dispatch('updateActiveCustomCommandData',
                        {
                            key: 'DeleteRequest',
                            data: value
                        })
                }
            },
            roles() {
                return this.$store.getters['customcommands'](this.activeCommandIndex);
            },
            CommandCharacter() {
                return this.$store.state.CommandCharacter;
            }
        },
        methods: {
            setActiveCommand(command) {
                if (this.activeCommand !== null && this.activeCommandIndex >= 0) {
                    this.$store.dispatch('editCustomCommandsClass', {
                        index: this.activeCommandIndex,
                        classData: {'active': false}
                    });
                }
                this.$store.dispatch('updateActiveCustomCommand', command);
                if (command !== null && command !== undefined) {
                    this.$store.dispatch('editCustomCommandsClass', {
                        index: this.customCommands.indexOf(command),
                        classData: {'active': true}
                    });
                }
            },
            addRoleWhitelist(role) {
                this.$store.dispatch('editCustomCommandsRoles', {key: this.activeCommandIndex, data: role.id});
            },
            removeRoleWhitelist(role) {
                this.$store.dispatch('removeCustomCommandsRoles', {key: this.activeCommandIndex, data: role.id});
            },
            newCommand() {
                const command = {
                    ID: 'command' + this.customCommands.length,
                    Response: 'Response',
                    Description: '',
                    RoleWhitelist: [],
                    DeleteRequest: false
                };
                this.$store.dispatch('addCustomCommand', command);
                this.setActiveCommand(command);

                let duplicateCommand = this.isDuplicate(command);
                if (duplicateCommand) {
                    this.$store.dispatch('editCustomCommandsClass', {
                        index: this.customCommands.indexOf(command),
                        classData: {'has-danger': true}
                    });
                    this.$store.dispatch('editCustomCommandsClass', {
                        index: this.customCommands.indexOf(duplicateCommand),
                        classData: {'has-danger': true}
                    })
                }
            },
            removeCommand(command) {
                this.$store.dispatch('removeCustomCommand', command);
                if (command === this.activeCommand) {
                    if (this.customCommands.length > 0) {
                        this.setActiveCommand(this.customCommands[0]);
                    }
                    else {
                        this.setActiveCommand();
                    }
                }
            },
            inputName(attribute, command) {
                return this.formName + '[' + this.customCommands.indexOf(command) + ']' + '[' + attribute + ']'
            },
            roleName(attribute, command) {
                return this.inputName(attribute, command) + '[]';
            },
            updateActiveCommand(e) {
                this.$store.dispatch('updateActiveCustomCommandData', {
                    key: e.target.getAttribute('command-name'),
                    data: e.target.value
                });
                this.$store.dispatch('editCustomCommandsClass', {
                    index: this.activeCommandIndex,
                    classData: {'has-danger': !this.commandIsValid(this.activeCommand)}
                });

                for (let command of this.customCommands) {
                    let duplicateCommand = this.isDuplicate(command);
                    if (duplicateCommand) {
                        this.$store.dispatch('editCustomCommandsClass',
                            {
                                index: this.customCommands.indexOf(command),
                                classData: {'has-danger': true}
                            });
                        this.$store.dispatch('editCustomCommandsClass',
                            {
                                index: this.customCommands.indexOf(duplicateCommand),
                                classData: {'has-danger': true}
                            });
                    }
                    else {
                        let isValid = this.commandIsValid(command);
                        if (command.classData === undefined || ( command.classData !== undefined && command.classData['has-danger'] !== !isValid )) {
                            this.$store.dispatch('editCustomCommandsClass',
                                {
                                    index: this.customCommands.indexOf(command),
                                    classData: {'has-danger': !isValid}
                                });
                        }
                        /*else if (command.classData['has-danger'] !== !isValid) {
                            this.$store.dispatch('editCustomCommandsClass',
                                {
                                    index: this.customCommands.indexOf(command),
                                    classData: {'has-danger': !isValid}
                                });
                        }*/
                    }
                }
            },
            isDuplicate(check) {
                // Check if command already exists
                for (let command of this.customCommands) {
                    if (command.ID === check.ID && this.customCommands.indexOf(command) !== this.customCommands.indexOf(check)) {
                        return command;
                    }
                }
                return false;
            },
            isBotwinderCommand(check) {
                // Check if command already exists
                for (let id of this.botwinderCommands) {
                    if (id === check.ID) {
                        return true;
                    }
                }
                return false;
            },
            hasWhitespace(input) {
                return /^.*\s.*$/.test(input)
            },
            commandIsValid(command) {
                return !(command.ID.length === 0
                    || this.hasWhitespace(command.ID)
                    || this.isBotwinderCommand(command)
                    || command.Response.length === 0);

            }
        }
    }
</script>