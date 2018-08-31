import "./getter_types";
import {Config} from "../models/Config";
import {ConfigData} from "../models/ConfigData";

export const getters = {
    configInput: (state) => (storeName) => {
        if (state.config instanceof Config) {
            return state.config.retrieve(storeName);
        }
        return ConfigData.instanceFromApi(storeName, null);
    }
};
