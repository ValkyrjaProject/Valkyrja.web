import PublicGroup from "../../models/PublicGroup";
import {PublicRole} from "../../models/PublicRole";
import {BlankPublicGroup} from "../../models/BlankPublicGroup";
import {Guild} from "../../models/Guild";
import {Config} from "../../models/Config";
import {ADD_ARRAY_OBJECT} from "../mutation_types";

export const NoGroup = new BlankPublicGroup;
export const types = {
    NotAdded: 0,
    Public: 1,
    Member: 2,
    SubModerator: 3,
    Moderator: 4,
    Admin: 5
};
let stateTypes = {...types};
delete stateTypes.NotAdded;
const state = {
    selectedType: types.Public,
    types: stateTypes,
    selectedPublicGroup: NoGroup,
    publicGroups: [
        NoGroup
    ]
};

const mutations = {
    CHANGE_TYPE(state, selectedType) {
        for (const type of Object.values(state.types)) {
            if (type === selectedType) {
                state.selectedType = selectedType;
                break;
            }
        }
    },
    ADD_GROUP(state, group) {
        state.publicGroups.push(group);
    },
    CHANGE_ACTIVE_GROUP(state, group) {
        state.selectedPublicGroup = group;
    },
    CHANGE_ROLE_PERMISSION(state, payload) {
        payload.role.permission_level = payload.permission_level;
    },
    CHANGE_PUBLIC_ID(state, payload) {
        payload.role.public_id = payload.public_id;
    },
    CHANGE_GROUP_NAME(state, name) {
        state.selectedPublicGroup.name = name;
    },
    CHANGE_ROLE_LIMIT(state, limit) {
        state.selectedPublicGroup.role_limit = limit;
    },
};

const actions = {
    changeSelectedType({commit}, selectedType) {
        if (selectedType > 0) {
            commit("CHANGE_TYPE", selectedType);
        }
    },
    addPublicGroup({commit}, group) {
        if (!(group instanceof PublicGroup)) {
            throw new TypeError(`Object is not of type PublicGroup, it is of type ${group.constructor.name}`);
        }
        commit(ADD_ARRAY_OBJECT, {
            id: "role_groups",
            value: group,
        }, { root: true });
    },
    selectedPublicGroup({commit}, group) {
        commit("CHANGE_ACTIVE_GROUP", group);
    },
    addRole({commit, state}, role) {
        if (!(role instanceof PublicRole)) {
            let error = `Object is not of type PublicRole, it is of type ${role.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit("CHANGE_ROLE_PERMISSION", {
            role,
            permission_level: state.selectedType,
        });
        commit("CHANGE_PUBLIC_ID", {
            role,
            public_id: state.selectedPublicGroup.id,
        });
    },
    removeRole({commit, state}, role) {
        if (!(role instanceof PublicRole)) {
            let error = `Object is not of type PublicRole, it is of type ${role.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit("CHANGE_ROLE_PERMISSION", {
            role,
            permission_level: types.NotAdded,
        });
    },
    changeGroupName({commit, state}, name) {
        if (!(state.selectedPublicGroup instanceof PublicGroup)) {
            return;
        }
        commit("CHANGE_GROUP_NAME", name);
    },
    changeRoleLimit({commit}, limit) {
        if (!(state.selectedPublicGroup instanceof PublicGroup)) {
            return;
        }
        commit("CHANGE_ROLE_LIMIT", parseInt(limit));
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
                    && addedRole.permission_level > 0;
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
                    && addedRole.permission_level === state.selectedType
                    && (state.selectedType === types.Public ? addedRole.public_id === state.selectedPublicGroup.id : 1);
            }).length !== 0;
        });
    },
    publicGroups: (state, getters, rootState, rootGetters) => {
        let groups = rootGetters.configInput("role_groups");
        if (!(rootState.config instanceof Config) || !groups || !(groups.value instanceof Array)) {
            return [];
        }
        return groups.value;
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
