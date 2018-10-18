import {Channel} from "../../models/Channel";
import {Config} from "../../models/Config";
import {Guild} from "../../models/Guild";

const state = {
    /** @member {ProfileOption} */
    selectedProfile: null
};

const mutations = {
    CHANGE_IGNORED(state, payload) {
        payload.channel.ignored = payload.ignored;
    },
};

const actions = {
    changeField({commit, state}, channel) {
        if (!(channel instanceof Channel)) {
            let error = `Object is not of type Channel, it is of type ${channel.constructor.name}`;
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
