import {ADD_ARRAY_OBJECT} from "../mutation_types";
import {Config} from "../../models/Config";
import {Guild} from "../../models/Guild";
import {types} from "./RoleSelector";
import {CustomCommand} from "../../models/CustomCommand";
import ReactionRole from "../../models/ReactionRole";
import EmojiRole from "../../models/EmojiRole";
import {GuildRole} from "../../models/GuildRole";

const state = {
    selectedRole: null
};

const mutations = {
    SET_SELECTED_ROLE(state, role) {
        state.selectedRole = role;
    },
    CHANGE_TYPE(state, option) {
        if (state.selectedRole
            && state.selectedRole instanceof ReactionRole
            && option.hasOwnProperty("field")
            && option.hasOwnProperty("value")) {
            state.selectedRole[option.field] = option.value;
        }
    },
    DELETE_ROLE_FROM_INDEX(state, obj) {
        obj.array.splice(obj.index, 1);
    },
    ADD_ROLE(state, role) {
        state.selectedRole.roles.push(role);
    },
    DELETE_ROLE(state, role) {
        let index = state.selectedRole.roles.indexOf(role);
        state.selectedRole.roles.splice(index, 1);
    }
};

const actions = {
    addRole({commit}, role) {
        if (!(role instanceof GuildRole)) {
            let error = `Object is not of type GuildRole, it is of type ${role.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit("ADD_ROLE", role);
    },
    removeRole({commit}, role) {
        if (!(role instanceof GuildRole)) {
            let error = `Object is not of type GuildRole, it is of type ${role.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit("DELETE_ROLE", role);
    },
    addReactionRole({commit}, role) {
        if (!(role instanceof ReactionRole)) {
            let error = `Object is not of type ReactionRole, it is of type ${role.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit(ADD_ARRAY_OBJECT, {
            id: "reaction_roles",
            value: role,
        }, {root: true});
        commit("SET_SELECTED_ROLE", role);
    },
    removeReactionRole({commit, rootState}, role) {
        if (!(role instanceof ReactionRole)) {
            let error = `Object is not of type ReactionRole, it is of type ${role.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        let reactionRoles = rootState.config.find("reaction_roles");
        let index = reactionRoles.value.indexOf(role);
        if (index >= 0) {
            commit("DELETE_ROLE_FROM_INDEX", {
                array: reactionRoles.value,
                index: index
            });
        }
        if (role === state.selectedRole) {
            if (reactionRoles.length >= 0) {
                commit("SET_SELECTED_ROLE", reactionRoles[0]);
            }
            else {
                commit("SET_SELECTED_ROLE", null);
            }
        }
    },
    setActiveRole({commit}, role) {
        if (!(role instanceof ReactionRole)) {
            let error = `Object is not of type ReactionRole, it is of type ${role.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit("SET_SELECTED_ROLE", role);
    },
    changeField({commit}, option) {
        if (!(option.hasOwnProperty("field") && option.hasOwnProperty("value"))) {
            let error = "Object does not have 'field' and 'value' fields";
            log.error(error);
            throw new TypeError(error);
        }
        commit("CHANGE_TYPE", option);
    }
};

const getters = {
    roles: (state, getters, rootState, rootGetters) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }

        let reactionRoles = rootGetters.configInput("reaction_roles");
        return reactionRoles && reactionRoles.value ? reactionRoles.value : [];
    },
    availableRoles: (state, getters, rootState) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }

        return rootState.guild.roles.filter((role) => {
            return state.selectedRole.roles.filter((addedRole) => {
                return addedRole.id === role.id;
            }).length === 0;
        });
    },
    addedRoles: (state, getters, rootState) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }

        return rootState.guild.roles.filter((role) => {
            return state.selectedRole.roles.filter((addedRole) => {
                return addedRole.id === role.id;
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
