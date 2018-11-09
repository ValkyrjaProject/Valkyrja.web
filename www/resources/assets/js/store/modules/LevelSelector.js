import {Guild} from "../../models/Guild";
import {Config} from "../../models/Config";
import {PublicRole} from "../../models/PublicRole";

const state = {
    /** @member {Array} levels */
    levels: []
};

const mutations = {
    CHANGE_LEVEL(state, payload) {
        payload.role.level = payload.level;
    },
};

const actions = {
    changeLevel({commit, state}, payload) {
        if (!payload.hasOwnProperty("role") || !payload.hasOwnProperty("level")) {
            let error = "Payload does not have role and level properties";
            log.error(error);
            throw new TypeError(error);
        }
        if (!(payload.role instanceof PublicRole)) {
            let error = `Object is not of type PublicRole, it is of type ${payload.role.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit("CHANGE_LEVEL", {
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
            console.log(addedRole.level);
            return rootState.guild.roles.filter((role) => {
                return addedRole.id === role.id
                    && addedRole.level > 0;
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
