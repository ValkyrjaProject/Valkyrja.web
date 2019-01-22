import Vue from "vue";
import Vuex from "vuex";
import * as actions from "./actions";
import { getters } from "./getters";
import { state, mutations } from "./mutations";
import roleSelector from "./modules/RoleSelector";
import ignoredChannels from "./modules/IgnoredChannels";
import levelSelector from "./modules/LevelSelector";
import profileEditor from "./modules/ProfileEditor";
import customCommands from "./modules/CustomCommands";
import reactionRoles from "./modules/ReactionRoles";
import createLogger from "vuex/dist/logger";

Vue.use(Vuex);

// noinspection JSCheckFunctionSignatures
export default new Vuex.Store({
    strict: process.env.NODE_ENV !== "production",
    plugins: [createLogger({
        logger: window.log
    })],
    state,
    mutations,
    actions,
    getters,
    modules: {
        levelSelector,
        roleSelector,
        ignoredChannels,
        profileEditor,
        customCommands,
        reactionRoles,
    }
});
