<template>
    <div class="columns">
        <panel-list
            :value="commands"
            :add-button="true"
            class="column is-one-third"
            title="Available commands"
            @remove="deleteCommand"
            @input="changeCommand"
            @add="addCommand()"/>
        <custom-command-form class="column is-two-thirds"/>
    </div>
</template>

<script>
import PanelList from "../../../shared/structure/PanelList/PanelList";
import CustomCommandForm from "./CustomCommandForm";
import {CustomCommand} from "../../../../models/CustomCommand";

export default {
    name: "CustomCommandsConfig",
    components: {
        PanelList,
        CustomCommandForm,
    },
    computed: {
        commands() {
            return this.$store.getters["customCommands/commands"];
        }
    },
    methods: {
        addCommand() {
            let command = CustomCommand.newInstance(`Command ${this.commands.length}`);
            this.$store.dispatch("customCommands/addCommand", command);
        },
        changeCommand(command) {
            this.$store.dispatch("customCommands/changeCommand", command);
        },
        deleteCommand(command) {
            this.$store.dispatch("customCommands/deleteCommand", command);
        }
    }
};
</script>

<style scoped>

</style>
