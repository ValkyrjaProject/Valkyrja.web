import {ADD_ARRAY_OBJECT} from "../mutation_types";
import {Config} from "../../models/Config";
import {Guild} from "../../models/Guild";
import {types} from "./RoleSelector";
import {CustomCommand} from "../../models/CustomCommand";
import ReactionRole from "../../models/ReactionRole";
import EmojiRole from "../../models/EmojiRole";
import {GuildRole} from "../../models/GuildRole";

const state = {
    selectedReactionRole: null
};

const mutations = {
    SET_SELECTED_REACTION_ROLE(state, role) {
        state.selectedReactionRole = role;
    },
    CHANGE_TYPE(state, option) {
        if (state.selectedReactionRole
            && state.selectedReactionRole instanceof ReactionRole
            && option.hasOwnProperty("field")
            && option.hasOwnProperty("value")) {
            state.selectedReactionRole[option.field] = option.value;
        }
    },
    DELETE_ROLE_FROM_INDEX(state, obj) {
        obj.array.splice(obj.index, 1);
    },
    ADD_ROLE(state, role) {
        state.selectedReactionRole.roles.push(role);
    },
    DELETE_ROLE(state, role) {
        let index = state.selectedReactionRole.roles.indexOf(role);
        state.selectedReactionRole.roles.splice(index, 1);
    }
};

const actions = {
    addRole({commit}, role) {
        if (!(role instanceof EmojiRole)) {
            let error;
            if (role instanceof Object){
                error = `Object is not of type EmojiRole, it is of type ${role.constructor.name}`;
            }
            else {
                error = `Object is not of type EmojiRole, it is of type ${role}`;
            }
            log.error(error);
            throw new TypeError(error);
        }
        commit("ADD_ROLE", role);
    },
    removeRole({commit}, role) {
        if (!(role instanceof GuildRole)) {
            let error;
            if (role instanceof Object){
                error = `Object is not of type GuildRole, it is of type ${role.constructor.name}`;
            }
            else {
                error = `Object is not of type GuildRole, it is of type ${role}`;
            }
            log.error(error);
            throw new TypeError(error);
        }
        commit("DELETE_ROLE", role);
    },
    addReactionRole({commit}, role) {
        if (!(role instanceof ReactionRole)) {
            let error;
            if (role instanceof Object){
                error = `Object is not of type ReactionRole, it is of type ${role.constructor.name}`;
            }
            else {
                error = `Object is not of type ReactionRole, it is of type ${role}`;
            }
            log.error(error);
            throw new TypeError(error);
        }
        commit(ADD_ARRAY_OBJECT, {
            id: "reaction_roles",
            value: role,
        }, {root: true});
        commit("SET_SELECTED_REACTION_ROLE", role);
    },
    removeReactionRole({state, commit, rootState}, role) {
        if (!(role instanceof ReactionRole)) {
            let error;
            if (role instanceof Object){
                error = `Object is not of type ReactionRole, it is of type ${role.constructor.name}`;
            }
            else {
                error = `Object is not of type ReactionRole, it is of type ${role}`;
            }
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
            if (role === state.selectedReactionRole) {
                if (reactionRoles.value.length > 0) {
                    commit("SET_SELECTED_ROLE", reactionRoles.value[0]);
                }
                else {
                    commit("SET_SELECTED_ROLE", null);
                }
            }
        }
    },
    setActiveReactionRole({commit}, role) {
        if (!(role instanceof ReactionRole)) {
            let error;
            if (role instanceof Object){
                error = `Object is not of type ReactionRole, it is of type ${role.constructor.name}`;
            }
            else {
                error = `Object is not of type ReactionRole, it is of type ${role}`;
            }
            log.error(error);
            throw new TypeError(error);
        }
        commit("SET_SELECTED_REACTION_ROLE", role);
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
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild) || state.selectedReactionRole === null) {
            return [];
        }

        return rootState.guild.roles.filter(r => (state.selectedReactionRole && r !== state.selectedReactionRole.role));
    },
    addedRoles: (state, getters, rootState) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild) || state.selectedReactionRole === null) {
            return [];
        }

        return state.selectedReactionRole.roles;
    },
};


export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
