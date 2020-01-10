import {ConfigData} from "./ConfigData";
import {Config} from "./Config";
import {CustomCommand} from "./CustomCommand";

export default class ReactionRole extends ConfigData {

    static newInstance(id, roles) {
        let configData = new this;
        configData.id = id;
        configData.value = {
            roles
        };
        return configData;
    }

    set messageId(messageId) {
        this.id = messageId;
    }

    get messageId() {
        return this.id;
    }

    /**
     * @param {Array<GuildRole>} roles
     */
    set roles(roles) {
        this.value["roles"] = roles;
    }

    /**
     * @returns {Array<GuildRole>}
     */
    get roles() {
        return this.value["roles"];
    }

    /**
     * @param {GuildRole} role
     */
    addRole(role) {
        this.roles.push(role);
    }

    /**
     * @param {GuildRole} role
     */
    removeRole(role) {
        this.roles.splice(this.roles.indexOf(role), 1);
    }

    toString() {
        return this.id;
    }
}

export class ReactionRoleFactory {
    /**
     * @param {Array} values
     * @returns {Array<ReactionRole>}
     */
    static getConfigData(values) {
        let config_data = [];
        for (let i in values) {
            if (values[i] instanceof Array) {
                config_data.push(Config.getConfigData(values[i]));
            }
            else {
                /** @type {CustomCommand} */
                let command = ReactionRole.instanceFromApi(values[i]["id"], values[i]["roles"]);
                config_data.push(command);
            }
        }
        return config_data;
    }
}
