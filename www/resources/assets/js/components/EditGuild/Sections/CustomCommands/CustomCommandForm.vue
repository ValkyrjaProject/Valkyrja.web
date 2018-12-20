<template>
    <div class="panel">
        <div class="panel-heading">
            Selected custom command
        </div>
        <div class="panel-block">
            <div class="control field">
                <label for="custom_command_id">
                    <b>Id</b> - Unique command identifier, prefix+this is what you will use to run your command.
                </label>
                <div class="control has-icons-left is-expanded">
                    <input
                        id="custom_command_id"
                        :disabled="command === null"
                        v-model="command_id"
                        class="input"
                        type="text"
                        min="1"
                        placeholder="command">
                    <span class="icon is-small is-left">
                        {{ command_prefix }}
                    </span>
                </div>
            </div>
        </div>
        <div class="panel-block">
            <div class="control field">
                <label for="custom_command_response">
                    <b>Response message</b> - You can use <code v-pre>{{sender}}</code> or <code v-pre>{{mentioned}}</code> variables.
                </label>
                <div class="control is-expanded">
                    <input
                        id="custom_command_response"
                        :disabled="command === null"
                        v-model="response"
                        type="text"
                        class="input">
                </div>
            </div>
        </div>
        <div class="panel-block">
            <div class="control field">
                <label for="custom_command_desc">
                    <b>Description</b> - the <code>{{ command_prefix }}help</code> message.
                </label>
                <div class="control is-expanded">
                    <input
                        id="custom_command_desc"
                        v-model="description"
                        :disabled="command === null"
                        type="text"
                        class="input">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CustomCommandForm",
    computed: {
        command_prefix() {
            return this.config("command_prefix");
        },
        /**
         * Returns the selected custom command
         * @returns {CustomCommand} command
         */
        command() {
            return this.$store.state.customCommands.selectedCommand;
        },
        command_id: {
            get() {
                return this.command ? this.command.command_id : "";
            },
            set(value) {
                this.$store.dispatch("customCommands/changeField", {
                    field: "command_id",
                    value: value
                });
            }
        },
        response: {
            get() {
                return this.command ? this.command.response : "";
            },
            set(value) {
                this.$store.dispatch("customCommands/changeField", {
                    field: "response",
                    value: value
                });
            }
        },
        description: {
            get() {
                return this.command ? this.command.description : "";
            },
            set(value) {
                this.$store.dispatch("customCommands/changeField", {
                    field: "description",
                    value: value
                });
            }
        }
    },
    methods: {
        config(name) {
            return this.$store.getters.configInput(name).toString();
        }
    }
};
</script>

<style scoped>

</style>
