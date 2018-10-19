import {ConfigData} from "./ConfigData";

export class Profile extends ConfigData {
    /**
     * @param id
     * @param value
     * @returns {this}
     */
    static newInstance(option = "") {
        let profile = new this;
        profile.id = id;
        profile.value = {
            option: option,
            option_alt: "",
            property_order: 0,
            inline: 0,
        };
        return profile;
    }

    get option() {
        return this.value["option"];
    }

    set option(value) {
        this.value["option"] = value;
    }

    get option_alt() {
        return this.value["option_alt"];
    }

    set option_alt(value) {
        this.value["option_alt"] = value;
    }

    get property_order() {
        return this.value["property_order"];
    }

    set property_order(value) {
        this.value["option_alt"] = parseInt(value);
    }

    get inline() {
        return this.value["inline"];
    }

    set inline(value) {
        this.value["inline"] = (value == true ? 1 : 0);
    }

    toString() {
        return this.option;
    }
}
