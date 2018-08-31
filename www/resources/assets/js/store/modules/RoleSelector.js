import PublicGroup from "../../models/PublicGroup";
import {PublicRole} from "../../models/PublicRole";
import {Guild} from "../../models/Guild";
import {Config} from "../../models/Config";

const NoGroup = PublicGroup.createNameInstance(0, "No group");
export const types = {
    Public: 1,
    Member: 2,
    SubModerator: 3,
    Moderator: 4,
    Admin: 5
};
const state = {
    selectedType: types.Public,
    types,
    selectedPublicGroup: NoGroup,
    publicGroups: [
        NoGroup
    ],
    addedRoles: []
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
    ADD_ROLE(state, role) {
        //TODO: Need to add based on selected public group type and group
        state.addedRoles.push(role);
    },
    REMOVE_ROLE(state, role) {
        //TODO: Need to add based on selected public group type and group
        state.addedRoles.filter(r => r.id !== role.id);
    }
};

const actions = {
    changeSelectedType({commit}, selectedType) {
        commit("CHANGE_TYPE", selectedType);
    },
    addPublicGroup({commit}, group) {
        commit("ADD_GROUP", group);
    },
    selectedPublicGroup({commit}, group) {
        commit("CHANGE_ACTIVE_GROUP", group);
    },
    addRole({commit, dispatch}, role) {
        if (!(role instanceof PublicRole)) {
            throw new TypeError(`Object is not of type PublicRole, it is of type ${role.constructor.name}`);
        }
        commit("ADD_ROLE", role);
        dispatch("changeConfig", {
            storeName: "roleSelector",
            value: this.state.roles
        }, {
            root: true
        });
    },
    removeRole({commit, dispatch}, role) {
        if (!(role instanceof PublicRole)) {
            throw new TypeError(`Object is not of type PublicRole, it is of type ${role.constructor.name}`);
        }
        commit("REMOVE_ROLE", role);
        dispatch("changeConfig", {
            storeName: "roleSelector",
            value: this.state.roles
        }, {
            root: true
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
            //return role.permission_level === 0;
        });
    },
    addedRoles: (state, getters, rootState, rootGetters) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }
        return rootGetters.configInput("roles").value.filter((addedRole) => {
            return !(rootState.guild.roles.filter((role) => {
                return addedRole.id === role.id
                    && addedRole.permission_level === 1;
            }).length === 0);
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
