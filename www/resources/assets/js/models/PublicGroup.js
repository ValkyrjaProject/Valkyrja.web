import {ConfigData} from "./ConfigData";

export default class PublicGroup extends ConfigData {
    static createInstance(id, role_limit = 1, name = null) {
        let group = new PublicGroup();
        group.id = id;
        group.name = name;
        group.value = {};
        group.role_limit = role_limit;
        return group;
    }

    set role_limit(role_limit) {
        this.value["role_limit"] = role_limit;
    }

    get role_limit() {
        return this.value["role_limit"];
    }

    toString() {
        if (this.name) {
            return this.name;
        }
        return "Group " + this.id;
    }
}
