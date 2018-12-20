import {ConfigData} from "./ConfigData";
import {Config} from "./Config";

/**
 * Describes Profile Options for Valkyrja
 */
export class Profile extends ConfigData {
    /**
     * Returns new instance with default values
     * @param option Name of the profile
     * @returns {this}
     */
    static newInstance(option = "") {
        let profile = new this;
        profile.id = option;
        profile.value = {
            option: option,
            option_alt: "",
            label: "",
            property_order: 0,
            inline: 0,
        };
        return profile;
    }

    get option() {
        return this.value["option"];
    }

    set option(value) {
        this.value["id"] = value;
        this.value["option"] = value;
    }

    get option_alt() {
        return this.value["option_alt"];
    }

    set option_alt(value) {
        this.value["option_alt"] = value;
    }

    get label() {
        return this.value["label"];
    }

    set label(value) {
        this.value["label"] = value;
    }

    get property_order() {
        return this.value["property_order"];
    }

    set property_order(value) {
        this.value["property_order"] = parseInt(value);
    }

    get inline() {
        return this.value["inline"];
    }

    set inline(value) {
        this.value["inline"] = value ? 1 : 0;
    }

    toString() {
        return this.option;
    }
}


export class ProfileFactory {
    /**
     * @param {Array} values
     * @returns {Array<Profile>}
     */
    static getConfigData(values) {
        let config_data = [];
        for (let i in values) {
            if (values[i] instanceof Array) {
                config_data.push(Config.getConfigData(values[i]));
            }
            else {
                /** @type {Profile} */
                let public_role = Profile.instanceFromApi(values[i]["option"], values[i]);
                config_data.push(public_role);
            }
        }
        return config_data;
    }
}
