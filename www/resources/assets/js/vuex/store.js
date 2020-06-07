import Vue from 'vue'
import Vuex from 'vuex'

import * as actions from './actions'
import {createVuexLoader} from 'vuex-loading'

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
    tos: false,
    command_prefix: '',
    antispam_tolerance_ban: 0,
    roles: [],
    channels: [],
    categories: [],
    data: {},
    botwinderCommands: [],
    localisation: {
        data: {},
        defaults: {}
    },
    itemModifier: {
        custom_commands: {
            itemsList: [], // list of command Objects
            activeItem: null
        },
        roles: {
            itemsList: [], // list of command Objects
            activeItem: null
        },
        roleLevels: {
            itemsList: [], // list of command Objects
            activeItem: null
        },
        channels: {
            itemsList: [], // list of command Objects
            activeItem: null
        },
        profile_options: {
            itemsList: [], // list of command Objects
            activeItem: null
        },
        role_groups: {
            itemsList: [], // list of command Objects
            activeItem: null
        },
        reaction_roles: {
            itemsList: [], // list of command Objects
            activeItem: null
        }
    },
};

// mutations to modify state attributes
const mutations = {
    API_ERROR(state, error) {
        if (state.errors.indexOf(error) < 0) state.errors.push(error);
        state.forbidSubmitForm = true;
    },

    CLEAR_API_ERROR(state) {
        state.errors = [];
    },

    EDIT_SERVER_ID(state, id) {
        state.serverId = id
    },

    EDIT_COMMAND_PREFIX(state, character) {
        state.command_prefix = character
    },

    EDIT_ROLES(state, roles) {
        state.roles = roles;
    },

    EDIT_CHANNELS(state, channels) {
        state.channels = channels;
    },

    EDIT_CATEGORIES(state, categories) {
        state.categories = categories;
    },

    EDIT_DATA(state, payload) {
        state.data[payload.key].push(payload.data);
    },

    REMOVE_DATA(state, payload) {
        state.data[payload.key].splice(state.data[payload.key].findIndex(x => x === payload.data), 1);
    },

    EDIT_ITEM_ROLES(state, payload) {
        if (state.itemModifier[payload.formName].itemsList[payload.key][payload.roleName] === null) {
            state.itemModifier[payload.formName].itemsList[payload.key][payload.roleName] = [];
        }

        state.itemModifier[payload.formName]
            .itemsList[payload.key][payload.roleName]
            .push(payload.data);
    },

    REMOVE_ITEM_ROLES(state, payload) {
        state.itemModifier[payload.formName].itemsList[payload.key][payload.roleName]
            .splice(state
                    .itemModifier[payload.formName]
                    .itemsList[payload.key][payload.roleName]
                    .findIndex(x => x === payload.data)
                , 1);
    },

    UPDATE_ACTIVE_ITEM(state, payload) {
        state.itemModifier[payload.formName].activeItem = payload.item;
    },

    UPDATE_ACTIVE_ITEM_DATA(state, payload) {
        Vue.set(state.itemModifier[payload.formName].activeItem, payload.key, payload.data);
    },

    ADD_LEVEL(state, payload) {
        if (state.itemModifier[payload.formName].itemsList.findIndex(x => x['roleid'] === payload.item['roleid']) >= 0) {
            state.itemModifier[payload.formName].itemsList
                .splice(state.itemModifier[payload.formName].itemsList.findIndex(x => x['roleid'] === payload.item['roleid']), 1);
        }
        state.itemModifier[payload.formName].itemsList.push(payload.item);
    },

    ADD_EMOJI_ROLE(state, payload) {
        if (state.itemModifier[payload.formName].activeItem) {
            state.itemModifier[payload.formName].activeItem.roles.push(payload.item);
        }
    },

    REMOVE_EMOJI_ROLE(state, payload) {
        if (state.itemModifier[payload.formName].activeItem) {
            state.itemModifier[payload.formName].activeItem.roles
                .splice(state.itemModifier[payload.formName].activeItem.roles.findIndex(x => x.id === payload.item), 1);
        }
    },

    REMOVE_LEVEL(state, payload) {
        let newPayload = {
            roleid: payload.item['roleid'],
            level: "0"
        };
        state.itemModifier[payload.formName].itemsList
            .splice(state.itemModifier[payload.formName].itemsList.findIndex(x => x === payload.item), 1, newPayload);
    },


    ADD_ROLE(state, payload) {
        if (state.itemModifier[payload.formName].itemsList.findIndex(x => x['roleid'] === payload.item['roleid']) >= 0) {
            state.itemModifier[payload.formName].itemsList
                .splice(state.itemModifier[payload.formName].itemsList.findIndex(x => x['roleid'] === payload.item['roleid']), 1);
        }
        state.itemModifier[payload.formName].itemsList.push(payload.item);
    },

    UPDATE_ROLE(state, payload) {
        for (let property in payload.data) {
            if (payload.data.hasOwnProperty(property)){
                Vue.set(payload.role, property, payload.data[property]);
            }
        }
    },

    REMOVE_ROLE(state, payload) {
        let newPayload = {
            roleid: payload.item['roleid'],
            public_id: "0",
            permission_level: "0"
        };
        let role = state.itemModifier[payload.formName].itemsList.find(x => x === payload.item);
        console.log("role", role);
        if (role) {
            for (let property in newPayload) {
                if (role.hasOwnProperty(property)){
                    Vue.set(role, property, newPayload[property]);
                }
            }
        }
    },

    ADD_ITEM(state, payload) {
        state.itemModifier[payload.formName].itemsList.push(payload.item);
    },

    REMOVE_ITEM(state, payload) {
        state.itemModifier[payload.formName].itemsList
            .splice(state.itemModifier[payload.formName].itemsList.findIndex(x => x === payload.item), 1);
    },

    UPDATE_ITEM(state, payload) {
        Vue.set(payload.obj, payload.key, payload.data);
    },

    UPDATE_ITEM_MODIFIER(state, payload) {
        if (payload !== null) {
            if (!state.itemModifier.hasOwnProperty(payload.key) || payload.data === null) {
                Vue.set(state.itemModifier, payload.key, {itemsList: [], activeItem: null});
            }
            Vue.set(state.itemModifier[payload.key], 'itemsList', payload.data);
        }
    },

    UPDATE_REACTION_ROLES(state, payload) {
        if (payload !== null) {
            if (!state.itemModifier.hasOwnProperty(payload.key) || payload.data === null) {
                Vue.set(state.itemModifier, payload.key, {itemsList: [], activeItem: null});
            }
            let roles = [];
            if (payload.data instanceof Array) {
                for (let i = 0; i < payload.data.length; i++) {
                    let find = roles.find(role => role.messageid === payload.data[i].messageid);
                    if (find) {
                        find.roles.push({id: payload.data[i].roleid, emoji: payload.data[i].emoji})
                    }
                    else {
                        roles.push({messageid: payload.data[i].messageid, roles: [{id: payload.data[i].roleid, emoji: payload.data[i].emoji}] })
                    }
                }
            }
            else if (payload.data instanceof Object) {
                for (let [messageid, initRoles] of Object.entries(payload.data)) {
                    roles.push({messageid, roles: initRoles })
                }
            }
            Vue.set(state.itemModifier[payload.key], 'itemsList', roles);
        }
    },

    UPDATE_LOCALISATION(state, data) {
        if (data === null) {
            return
        }
        if (data instanceof Object) {
            state.localisation.data = data;
        }
        else {
            console.warn('localisation data is not an array!')
        }
    },

    UPDATE_LOCALISATION_DEFAULTS(state, defaults) {
        if (!(defaults instanceof Object)) {
            return;
        }
        for(let [key, value] of Object.entries(defaults)) {
            // if there is no data, set it
            if (!state.localisation.data[key]) {
                Vue.set(state.localisation.data, key, value.replace(/\\\\n/g, "\n").replace(/\\n/g, "\n"));
            }
        }
    },

    EDIT_ITEM_CLASS(state, payload) {
        if (state.itemModifier[payload.formName].itemsList[payload.index]['classData'] === undefined) Vue.set(state.itemModifier[payload.formName].itemsList[payload.index], 'classData', {});
        for (let key in payload.classData) {
            if (!payload.classData.hasOwnProperty(key)) continue;
            Vue.set(state.itemModifier[payload.formName].itemsList[payload.index]['classData'], key, payload.classData[key]);
        }
    },

    UPDATE_STATE(state, payload) {
        if (typeof payload.data === 'object' && payload.key === null) {
            state = Object.assign(state, payload.data)
        }
        else {
            Vue.set(state.data, payload.key, (payload.data || []));
        }
    },

    UPDATE_STORE_VALUE(state, payload) {
        state[payload.key] = payload.data;
    },

    UPDATE_TOS(state, value) {
        state.tos = !!JSON.parse(String(!!value).toLowerCase());
    },

    UPDATE_BOTWINDER_COMMANDS(state, value) {
        state.botwinderCommands = value
    },

    SET_LOCALISATION_VALUE(state, {key, value}) {
        Vue.set(state.localisation.data, key, value);
    }
};

const getters = {
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
