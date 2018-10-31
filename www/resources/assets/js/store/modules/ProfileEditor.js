import {Config} from "../../models/Config";
import {Guild} from "../../models/Guild";
import {Profile} from "../../models/Profile";
import {ADD_ARRAY_OBJECT} from "../mutation_types";

const state = {
    /** @member {Profile|null} */
    selectedProfile: null
};

const mutations = {
    SET_SELECTED_PROFILE(state, profile) {
        state.selectedProfile = profile;
    },
    CHANGE_TYPE(state, option) {
        if (state.selectedProfile.value.hasOwnProperty(option.field)) {
            state.selectedProfile.value[option.field] = option.value;
        }
    }
};

const actions = {
    addProfile({commit, state}, profile) {
        if (!(profile instanceof Profile)) {
            let error = `Object is not of type Profile, it is of type ${profile.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit(ADD_ARRAY_OBJECT, {
            id: "profile_options",
            value: profile,
        }, { root: true });
    },
    setSelectedProfile({commit, state}, profile) {
        if (!(profile instanceof Profile)) {
            let error = `Object is not of type Profile, it is of type ${profile.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit("SET_SELECTED_PROFILE", profile);
    },
    changeField({commit}, option) {
        if (!(option.hasOwnProperty("field") && option.hasOwnProperty("value"))) {
            let error = "Object does not have field and value fields";
            log.error(error);
            throw new TypeError(error);
        }
        commit("CHANGE_TYPE", option);
    },
};


const getters = {
    profiles: (state, getters, rootState, rootGetters) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }
        let profiles = rootGetters.configInput("profile_options");
        return profiles.value ? profiles.value : [];
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
