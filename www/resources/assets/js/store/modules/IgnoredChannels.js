import {Config} from "../../models/Config";
import {Guild} from "../../models/Guild";
import {Channel} from "../../models/Channel";

const state = {
};

const mutations = {
    CHANGE_IGNORED(state, payload) {
        payload.channel.ignored = payload.ignored;
    },
};

const actions = {
    addChannel({commit, state}, channel) {
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
    removeChannel({commit, state}, channel) {
        if (!(channel instanceof Channel)) {
            let error = `Object is not of type Channel, it is of type ${channel.constructor.name}`;
            log.error(error);
            throw new TypeError(error);
        }
        commit("CHANGE_IGNORED", {
            channel: channel,
            ignored: 0,
        });
    },
};

const getters = {
    availableChannels: (state, getters, rootState, rootGetters) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }
        return rootGetters.configInput("channels").value.filter((addedChannel) => {
            return rootState.guild.channels.filter((channel) => {
                return addedChannel.id === channel.id
                    && addedChannel.ignored;
            }).length === 0;
        });
    },
    ignoredChannels: (state, getters, rootState, rootGetters) => {
        if (!(rootState.config instanceof Config) || !(rootState.guild instanceof Guild)) {
            return [];
        }
        return rootGetters.configInput("channels").value.filter((addedChannel) => {
            return rootState.guild.channels.filter((channel) => {
                return addedChannel.id === channel.id
                    && addedChannel.ignored;
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
