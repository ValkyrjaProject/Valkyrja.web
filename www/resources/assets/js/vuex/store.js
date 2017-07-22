import Vue from 'vue'
import Vuex from 'vuex'

import * as actions from './actions'

Vue.use(Vuex);

// root state
const state = {
    serverId: '',
    commandCharacter: '',
    roles: [],
    channels: [],
    data: {
        CustomCommands: {
            commandsList: [], // list of command Objects
            activeCommand: null
        }
    },
    botwinderCommands: []
};

// mutations to modify state attributes
const mutations = {
    EDIT_SERVER_ID (state, id) {
        state.serverId = id
    },

    EDIT_COMMAND_CHARACTER (state, character) {
        state.commandCharacter = character
    },

    EDIT_ROLES (state, roles) {
        state.roles = roles;
    },

    EDIT_CHANNELS (state, channels) {
        state.channels = channels;
    },

    EDIT_DATA (state, payload) {
        state.data[payload.key].push(payload.data);
    },

    REMOVE_DATA (state, payload) {
        state.data[payload.key].splice(state.data[payload.key].findIndex(x => x===payload.data), 1);
    },

    EDIT_CUSTOM_COMMANDS_ROLES (state, payload) {
        if (state.data.CustomCommands.commandsList[payload.key].RoleWhitelist === null) state.data.CustomCommands.commandsList[payload.key].RoleWhitelist = [];
        state.data.CustomCommands.commandsList[payload.key].RoleWhitelist.push(payload.data);
    },

    REMOVE_CUSTOM_COMMANDS_ROLES (state, payload) {
        state.data.CustomCommands.commandsList[payload.key].RoleWhitelist
            .splice(state.data.CustomCommands.commandsList[payload.key].RoleWhitelist.findIndex(x => x===payload.data), 1);
    },

    UPDATE_ACTIVE_CUSTOM_COMMAND (state, payload) {
        state.data.CustomCommands.activeCommand = payload;
    },

    UPDATE_ACTIVE_CUSTOM_COMMAND_DATA (state, payload) {
        Vue.set(state.data.CustomCommands.activeCommand, payload.key, payload.data);
    },

    ADD_CUSTOM_COMMAND (state, payload) {
        state.data.CustomCommands.commandsList.push(payload);
    },

    REMOVE_CUSTOM_COMMAND (state, payload) {
        state.data.CustomCommands.commandsList
            .splice(state.data.CustomCommands.commandsList.findIndex(x => x===payload), 1);
    },

    UPDATE_CUSTOM_COMMANDS (state, payload) {
        if (payload !== null) {
            state.data.CustomCommands.commandsList = payload;
        }
    },

    EDIT_CUSTOM_COMMANDS_CLASS (state, payload) {
        state.data.CustomCommands.commandsList[payload.index]['classData'] = payload.classData;
    },

    UPDATE_STATE (state, payload) {
        Vue.set(state.data, payload.key, payload.data);
    },

    UPDATE_COMMAND_CHARACTER (state, value) {
        state.commandCharacter = value;
    },

    UPDATE_BOTWINDER_COMMANDS (state, value) {
        state.botwinderCommands = value
    }
};

const getters = {
    roles: state => (attribute) => {
        let selected = state.roles.filter(function (e) {
            return state.data[attribute].includes(e['id']);
        });
        let available = state.roles.filter(function (e) {
            return !state.data[attribute].includes(e['id']);
        });
        return {selected: selected, available: available};
    },
    channels: state => (attribute) => {
        let selected = state.channels.filter(function (e) {
            return state.data[attribute].includes(e['id']);
        });
        let available = state.channels.filter(function (e) {
            return state.data[attribute].includes(e['id']);
        });
        return {selected: selected, available: available};
    },
    customcommands: state => (attribute) => {
        let whitelist = state.data.CustomCommands.commandsList[attribute].RoleWhitelist;
        if (whitelist === null) whitelist = [];
        let selected = state.roles.filter(e => {
            return whitelist.includes(e['id']);
        });
        let available = state.roles.filter(e => {
            return !whitelist.includes(e['id']);
        });
        return {
            selected: selected,
            available: available
        };
    }
};

export default new Vuex.Store({
    state,
    mutations,
    actions,
    getters
})