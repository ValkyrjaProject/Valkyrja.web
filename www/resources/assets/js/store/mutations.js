import "./mutation_types";
import {createGuild, Guild} from "../models/Guild";
import lscache from "lscache";
import {
    ADD_ARRAY_OBJECT,
    ADD_CONFIG,
    ADD_GUILDS,
    ADD_USER,
    API_ERROR,
    CHANGE_CONFIG,
    INITIALIZE_USER,
    REMOVE_ARRAY_OBJECT
} from "./mutation_types";
import {Config} from "../models/Config";
import {ConfigData} from "../models/ConfigData";

export const state = {
    /** @member {Array<Guild>} **/
    guilds: [],
    /** @member {Guild|Object} **/
    guild: {},
    /** @member {Config|Object} **/
    config: {},
    user: {
        name: null,
        avatar: null
    }
};

export const mutations = {
    [ADD_GUILDS](state, guilds) {
        let formattedGuilds = [];
        for (const guild of guilds) {
            formattedGuilds.push(Guild.createGuild(guild));
        }
        state.guilds = formattedGuilds;
    },

    [ADD_CONFIG](state, configData) {
        const {guild, config} = configData;
        log.debug("Creating Guild model and adding to store");
        state.guild = Guild.createGuild(guild, true);
        log.debug("Adding config data");
        state.config = Config.instanceFromApi(config);
        state.config.addGuildData(state.guild);
    },

    [ADD_USER](state, user) {
        log.debug("Adding user");
        state.user = user;
    },

    [INITIALIZE_USER](state) {
        log.debug("Initializing user from cache");
        if (lscache.get("user")) {
            log.debug("Found user from cache, setting state");
            state.user = JSON.parse(lscache.get("user"));
        }
    },

    [CHANGE_CONFIG](state, configData) {
        if (!(configData.hasOwnProperty("storeName") && configData.hasOwnProperty("value"))) {
            let error = new TypeError("Object does not have 'storeName' and 'value' fields");
            log.error(error);
            throw error;
        }

        let conf = state.config.find(configData.storeName);
        if (conf instanceof ConfigData) {
            Vue.set(conf, "value", configData.value);
        }
    },

    [ADD_ARRAY_OBJECT](state, payload) {
        let data = state.config.find(payload.id);

        if (data instanceof ConfigData && data.value instanceof Array) {
            data.value.push(payload.value);
        }
        else if (payload.value instanceof ConfigData) {
            Vue.set(state.config.config_data, payload.id, ConfigData.newInstance(payload.id, [payload.value]));
        }
        else {
            let error = new Error("Cannot add object. Array does not exist or payload.value is not of ConfigData instance.");
            log.error(error);
            throw error;
        }
    },

    [REMOVE_ARRAY_OBJECT](state, payload) {
        let data = state.config.find(payload.id);

        if (data instanceof ConfigData && data.value instanceof Array || payload.value instanceof ConfigData) {
            data.value.splice(data.value.indexOf(payload.value), 1);
        } else {
            let error = new Error("Cannot add object. Array does not exist or payload.value is not of ConfigData instance.");
            log.error(error);
            throw error;
        }
    }
};
