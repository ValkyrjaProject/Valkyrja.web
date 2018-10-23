import {Config} from "../../models/Config";
import {Guild} from "../../models/Guild";
import {Profile} from "../../models/Profile";

const state = {
    /** @member {ProfileOption} */
    selectedProfile: null
};

const mutations = {
    PUSH_PROFILES(state, profile) {
        state.selectedProfile = profile;
    },
};

const actions = {
    addProfile({commit, state}, profile) {
        if (!(profile instanceof Profile)) {
            let error = `Object is not of type Profile, it is of type ${profile.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit("PUSH_PROFILES", profile);
    },
};


const getters = {
    profiles: (state, getters, rootState, rootGetters) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }
        let profiles = rootGetters.configInput("profile_options");
        return profiles ? profiles : [];
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
