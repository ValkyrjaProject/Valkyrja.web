import {ConfigData} from "./ConfigData";
import {Config} from "./Config";
import {Guild} from "./Guild";

export default class PublicGroup extends ConfigData {
    static createInstance(id, role_limit = 1, name = "") {
        let group = new PublicGroup();
        group.id = id;
        group.value = {};
        group.name = name;
        group.role_limit = role_limit;
        return group;
    }

    set role_limit(role_limit) {
        this.value["role_limit"] = role_limit;
    }

    get role_limit() {
        return this.value["role_limit"];
    }

    set name(name) {
        this.value["name"] = name;
    }

    get name() {
        return this.value["name"];
    }

    toString() {
        if (this.name) {
            return this.name;
        }
        return "Group " + this.id;
    }
}


export class PublicGroupFactory {
    /**
     * @param {Array} values
     * @returns {Array<PublicGroup>}
     */
    static getConfigData(values) {
        if (!Array.isArray(values)) {
            throw new TypeError("'values' parameter is not an array");
        }
        let config_data = [];
        for (let i in values) {
            if (values[i] instanceof Array) {
                config_data.push(Config.getConfigData(values[i]));
            }
            else if (!(values[i] instanceof Object) || !values[i].hasOwnProperty("roleid")) {
                throw new TypeError("'values' entry does not have roleid field");
            }
            else {
                /** @type {PublicGroup} */
                let public_role = PublicGroup.instanceFromApi(values[i]["roleid"], values[i]);
                config_data.push(public_role);
            }
        }
        return config_data;
    }
}
