import Vue from 'vue'
import Vuex from 'vuex'

import * as actions from './actions'
import { createVuexLoader } from 'vuex-loading'

const VuexLoading = createVuexLoader({
    moduleName: 'loading',
    componentName: 'v-loading',
    className: 'v-loading',
});

Vue.use(Vuex);
Vue.use(VuexLoading);

// root state
const state = {
    errors: [],
    forbidSubmitForm: false,
    serverId: '',
    CommandCharacter: '',
    SpambotBanLimit: 0,
    roles: [],
    channels: [],
    data: {
        CustomCommands: {
            itemsList: [], // list of command Objects
            activeItem: null
        }
    },
    botwinderCommands: [],
    itemModifier: {
        /*CustomCommands: {
            itemsList: [], // list of command Objects
            activeItem: null
        }*/
    }
};

// mutations to modify state attributes
const mutations = {
    API_ERROR (state, error) {
        if (state.errors.indexOf(error) < 0) state.errors.push(error);
        state.forbidSubmitForm = true;
    },

    CLEAR_API_ERROR (state) {
        state.errors = [];
    },

    EDIT_SERVER_ID (state, id) {
        state.serverId = id
    },

    EDIT_COMMAND_CHARACTER (state, character) {
        state.CommandCharacter = character
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

    EDIT_ITEM_ROLES (state, payload) {
        if (state.itemModifier[payload.formName].itemsList[payload.key][payload.roleName] === null) state.itemModifier[payload.formName].itemsList[payload.key][payload.roleName] = [];
        state
            .itemModifier[payload.formName]
            .itemsList[payload.key][payload.roleName]
            .push(payload.data);
    },

    REMOVE_ITEM_ROLES (state, payload) {
        state.itemModifier[payload.formName].itemsList[payload.key][payload.roleName]
            .splice(state
                .itemModifier[payload.formName]
                .itemsList[payload.key][payload.roleName]
                .findIndex(x => x===payload.data)
                , 1);
    },

    UPDATE_ACTIVE_ITEM (state, payload) {
        state.itemModifier[payload.formName].activeItem = payload.item;
    },

    UPDATE_ACTIVE_ITEM_DATA (state, payload) {
        Vue.set(state.itemModifier[payload.formName].activeItem, payload.key, payload.data);
    },

    ADD_ITEM (state, payload) {
        state.itemModifier[payload.formName].itemsList.push(payload.item);
    },

    REMOVE_ITEM (state, payload) {
        state.itemModifier[payload.formName].itemsList
            .splice(state.itemModifier[payload.formName].itemsList.findIndex(x => x===payload.item), 1);
    },

    UPDATE_ITEM_MODIFIER (state, payload) {
        if (payload !== null) {
            if (!state.itemModifier.hasOwnProperty(payload.key)) {
                Vue.set(state.itemModifier, payload.key, {itemsList: [], activeItem: null});
            }
            Vue.set(state.itemModifier[payload.key], 'itemsList', payload.data);
        }
    },

    EDIT_ITEM_CLASS (state, payload) {
        if (state.itemModifier[payload.formName].itemsList[payload.index]['classData'] === undefined) Vue.set(state.itemModifier[payload.formName].itemsList[payload.index], 'classData', {});
        for (let key in payload.classData) {
            if (!payload.classData.hasOwnProperty(key)) continue;
            //state.itemModifier.CustomCommands.commandsList[payload.index]['classData'][key] = payload.classData[key];
            Vue.set(state.itemModifier[payload.formName].itemsList[payload.index]['classData'], key, payload.classData[key]);
            //state.itemModifier.CustomCommands.commandsList[payload.index]['classData'].splice(key, 1, payload.classData[key]);
        }
    },

    UPDATE_STATE (state, payload) {
        Vue.set(state.data, payload.key, payload.data);
    },

    UPDATE_STORE_VALUE (state, payload) {
        state[payload.key] = payload.data;
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
            return !state.data[attribute].includes(e['id']);
        });
        return {selected: selected, available: available};
    },
    item_modifier: state => (attribute) => {
        let whitelist = state.itemModifier[attribute.formName].itemsList[attribute.index][attribute.roleName];
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
    plugins: [VuexLoading.Store],
    state,
    mutations,
    actions,
    getters
})