import {ADD_ARRAY_OBJECT} from "../mutation_types";
import {Config} from "../../models/Config";
import {Guild} from "../../models/Guild";
import {types} from "./RoleSelector";
import {CustomCommand} from "../../models/CustomCommand";

const state = {
    roles: [],
    availableRoles: [],
    addedRoles: [],
    emoji: "",
};

const mutations = {
};

const actions = {
    addRole({commit}, command) {
    },
    removeRole({commit}, command) {
    },
    addReactionRole({commit}, command) {

    },
};

const getters = {
    roles: (state, getters, rootState, rootGetters) => {
    },
    availableRoles: (state, getters, rootState, rootGetters) => {
    },
    addedRoles: (state, getters, rootState, rootGetters) => {

    },
};


export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
