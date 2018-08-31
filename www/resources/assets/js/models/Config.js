import {ConfigData} from "./ConfigData";
import {PublicRole, PublicRoleFactory} from "./PublicRole";

// Main class containing a list of only ConfigData instances and lists of ConfigData instances
export class Config {
    /** @type {Array<ConfigData>} */
    config_data;

    /** @type {Array<ConfigErrors>} */
    errors;

    /**
     * @param {Array} values
     * @returns {Config}
     */
    static instanceFromApi(values) {
        let config = new Config;
        config.config_data = Config.getConfigData(values);
        return config;
    }

    /**
     * @param {Array} values
     * @returns {Array<ConfigData>}
     */
    static getConfigData(values) {
        let config_data = [];
        for (let i in values) {
            let arrayConfig;
            if (i === "roles") {
                arrayConfig = ConfigData.instanceFromApi(i, PublicRoleFactory.getConfigData(values[i]));
            }
            else if (values[i] instanceof Array) {
                arrayConfig = ConfigData.instanceFromApi(i, this.getConfigData(values[i]));
            }
            else {
                arrayConfig = ConfigData.instanceFromApi(i, values[i]);
            }
            config_data.push(arrayConfig);
        }
        return config_data;
    }

    /**
     * Change value from a specific config data createInstance
     * @param id
     * @param value
     */
    change(id, value) {
        let config = this.find(id);
        config.value = value;
    }

    /**
     * Retrieves the config matching a specific data
     * @param id
     * @returns {ConfigData}
     */
    retrieve(id) {
        return this.find(id);
    }

    find(id) {
        return this.config_data.find(config => config.id === id);
    }
}




