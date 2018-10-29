import Vue from "vue";
import Vuex from "vuex";
import * as actions from "./actions";
import { getters } from "./getters";
import { state, mutations } from "./mutations";
import roleSelector from "./modules/RoleSelector";
import ignoredChannels from "./modules/IgnoredChannels";
import levelSelector from "./modules/LevelSelector";
import profileEditor from "./modules/ProfileEditor";

Vue.use(Vuex);

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== "production",
    state,
    mutations,
    actions,
    getters,
    modules: {
        levelSelector,
        roleSelector,
        ignoredChannels,
        profileEditor,
    }
});
