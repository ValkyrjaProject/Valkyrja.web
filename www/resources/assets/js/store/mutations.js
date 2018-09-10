import "./mutation_types";
import {createGuild} from "../models/Guild";
import lscache from "lscache";
import {ADD_CONFIG, ADD_GUILDS, ADD_USER, CHANGE_CONFIG, INITIALIZE_USER} from "./mutation_types";
import {Config} from "../models/Config";

export const state = {
    guilds: [],
    guild: {},
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
            formattedGuilds.push(createGuild(guild));
        }
        state.guilds = formattedGuilds;
    },

    [ADD_CONFIG](state, configData) {
        const {guild, config} = configData;
        log.debug("Creating Guild model and adding to store");
        state.guild = createGuild(guild, true);
        log.debug("Adding config data");
        state.config = Config.instanceFromApi(config);
        state.config.addGuildData(state.guild);
        console.log("state.config", state.config);
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
        state.config.change(configData.storeName, configData.value);
    },
};
