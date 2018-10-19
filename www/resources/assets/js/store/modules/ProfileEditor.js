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

    CHANGE_IGNORED(state, payload) {
        payload.channel.ignored = payload.ignored;
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
    changeField({commit, state}, channel) {
        if (!(channel instanceof Profile)) {
            let error = `Object is not of type Profile, it is of type ${channel.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit("CHANGE_IGNORED", {
            channel: channel,
            ignored: 1,
        });
    },
};


const getters = {
    profiles: (state, getters, rootState, rootGetters) => {
        return [];
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
};
