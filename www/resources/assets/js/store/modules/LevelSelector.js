import {Guild} from "../../models/Guild";
import {Config} from "../../models/Config";
import {PublicRole} from "../../models/PublicRole";

const state = {
    /** @member {Array} levels */
    levels: [],
    /** @member {Number} selectedLevel */
    selectedLevel: null
};

const mutations = {
    ADD_LEVEL(state, level) {
        state.levels.push(parseInt(level));
    },
    CHANGE_SELECTED_LEVEL(state, level) {
        state.selectedLevel = parseInt(level);
    },
    CHANGE_ROLE_LEVEL(state, payload) {
        payload.role.level = payload.level;
    },
};

const actions = {
    addLevel({commit, state}, level) {
        log.debug(`Adding level ${level}`);
        commit("ADD_LEVEL", level);
    },
    changeSelectedLevel({commit, state}, level) {
        log.debug(`Changing selected level from ${state.selectedLevel} to ${level}`);
        commit("CHANGE_SELECTED_LEVEL", level);
    },
    changeRoleLevel({commit, state}, payload) {
        if (!payload.hasOwnProperty("role") || !payload.hasOwnProperty("level")) {
            let error = new TypeError("Payload does not have role and level properties");
            log.error(error);
            throw error;
        }
        if (!(payload.role instanceof PublicRole)) {
            let error = new TypeError(`Object is not of type PublicRole, it is of type ${payload.role.constructor.name}`);
            log.error(error);
            throw error;
        }
        commit("CHANGE_ROLE_LEVEL", {
            role: payload.role,
            level: payload.level,
        });
    },
};

const getters = {
    availableRoles: (state, getters, rootState, rootGetters) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }
        return rootGetters.configInput("roles").value.filter((addedRole) => {
            return rootState.guild.roles.filter((role) => {
                return addedRole.id === role.id
                    && addedRole.level > 0;
            }).length === 0;
        });
    },
    addedRoles: (state, getters, rootState, rootGetters) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }
        return rootGetters.configInput("roles").value.filter((addedRole) => {
            return rootState.guild.roles.filter((role) => {
                return addedRole.id === role.id
                    && addedRole.level === state.selectedLevel;
            }).length !== 0;
        });
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
