import {ADD_ARRAY_OBJECT} from "../mutation_types";
import {Config} from "../../models/Config";
import {Guild} from "../../models/Guild";
import {types} from "./RoleSelector";
import {CustomCommand} from "../../models/CustomCommand";

const state = {
    /** @member {CustomCommand|null} */
    selectedCommand: null
};

const mutations = {
    SET_SELECTED_COMMAND(state, command) {
        state.selectedCommand = command;
    },
    CHANGE_TYPE(state, option) {
        if (state.selectedCommand
            && state.selectedCommand instanceof CustomCommand
            && option.hasOwnProperty("field")
            && option.hasOwnProperty("value")) {
            state.selectedCommand[option.field] = option.value;
        }
    }
};

const actions = {
    addCommand({commit}, command) {
        commit(ADD_ARRAY_OBJECT, {
            id: "custom_commands",
            value: command,
        }, {root: true});
        commit("SET_SELECTED_COMMAND", command);
    },
    deleteCommand({commit, state, rootState}, command) {
        let commands = rootState.config.find("custom_commands");
        let index = commands.value.indexOf(command);
        if (index >= 0) {
            commands.value.splice(index, 1);
        }
        if (command === state.selectedCommand) {
            commit("SET_SELECTED_COMMAND", commands[0]);
        }
    },
    changeCommand({commit}, command) {
        if (command instanceof CustomCommand) {
            commit("SET_SELECTED_COMMAND", command);
        }
    },
    changeField({commit}, option) {
        if (!(option.hasOwnProperty("field") && option.hasOwnProperty("value"))) {
            let error = "Object does not have 'field' and 'value' fields";
            log.error(error);
            throw new TypeError(error);
        }
        commit("CHANGE_TYPE", option);
    },
};

const getters = {
    commands: (state, getters, rootState, rootGetters) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }
        let commands = rootGetters.configInput("custom_commands");
        if (commands.value === null) {
            return [];
        }
        return commands.value;
    },
};


export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
