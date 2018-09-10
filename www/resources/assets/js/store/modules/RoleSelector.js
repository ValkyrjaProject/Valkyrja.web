import PublicGroup from "../../models/PublicGroup";
import {PublicRole} from "../../models/PublicRole";
import {Guild} from "../../models/Guild";
import {Config} from "../../models/Config";

const NoGroup = PublicGroup.createNameInstance(0, "No group");
export const types = {
    NotAdded: 0,
    Public: 1,
    Member: 2,
    SubModerator: 3,
    Moderator: 4,
    Admin: 5
};
let stateTypes = Object.assign({}, types);
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
        //TODO: Need to add based on selected public group type and group
        payload.role.permission_level = payload.permission_level;
    },
};

const actions = {
    changeSelectedType({commit}, selectedType) {
        if (selectedType > 0) {
            commit("CHANGE_TYPE", selectedType);
        }
    },
    addPublicGroup({commit}, group) {
        commit("ADD_GROUP", group);
    },
    selectedPublicGroup({commit}, group) {
        commit("CHANGE_ACTIVE_GROUP", group);
    },
    addRole({commit, state, dispatch, rootGetters}, role) {
        if (!(role instanceof PublicRole)) {
            throw new TypeError(`Object is not of type PublicRole, it is of type ${role.constructor.name}`);
        }
        commit("CHANGE_ROLE_PERMISSION", {
            role,
            permission_level: state.selectedType,
        });
    },
    removeRole({commit, state, dispatch, rootGetters}, role) {
        if (!(role instanceof PublicRole)) {
            throw new TypeError(`Object is not of type PublicRole, it is of type ${role.constructor.name}`);
        }
        commit("CHANGE_ROLE_PERMISSION", {
            role,
            permission_level: types.NotAdded,
        });
    }
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
                    && (state.selectedType === types.Public ? role.public_id === this.selectedPublicGroup : 1);
            }).length !== 0;
        });
    }
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
