import {Config} from "../models/Config";
import {ConfigData} from "../models/ConfigData";

export const getters = {
    /**
     * Finds and retrieves ConfigData instance from Config based on parameter.
     * If Config is not yet initialized it will return a new ConfigData instance with value null.
     * @param state
     * @returns {Function}
     */
    configInput: state => storeName => {
        if (state.config instanceof Config) {
            let instance = state.config.retrieve(storeName);
            if (instance) {
                return instance;
            }
        }
        return ConfigData.instanceFromApi(storeName, null);
    }
};
