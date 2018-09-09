import {ConfigData} from "./ConfigData";
import {Config} from "./Config";
import {Guild} from "./Guild";

export class PublicRole extends ConfigData {

    /**
     * @param id
     * @param value
     * @returns {PublicRole}
     */
    static createInstance(id, value) {
        let configData = new PublicRole;
        configData.id = id;
        configData.value = value;
        configData.original_value = value;
        return configData;
    }

    static createNewRole(id, guild_role = null) {
        let newRole = new PublicRole();
        newRole.id = id;
        newRole.value = {
            roleid: id,
            permission_level: 0,
            public_id: "0",
            logging_ignored: 0,
            antispam_ignored: 0,
            level: "0",
        };
        if (guild_role) {
            newRole.value["guild_role"] = guild_role;
        }
        return newRole;
    }

    get permission_level() {
        return parseInt(this.value["permission_level"]);
    }

    set permission_level(level) {
        this.value["permission_level"] = parseInt(level);
    }

    get public_id() {
        return this.value["public_id"];
    }

    set public_id(id) {
        this.value["public_id"] = id;
    }

    /**
     * @returns {GuildRole}
     */
    get guild_role() {
        return this.value["guild_role"];
    }

    set guild_role(role) {
        this.value["guild_role"] = role;
    }

    toString() {
        if (this.guild_role) {
            return this.guild_role.name;
        }
        return "Not a valid role";
    }
}

export class PublicRoleFactory {
    /**
     * @param {Array} values
     * @returns {Array<PublicRole>}
     */
    static getConfigData(values) {
        let config_data = [];
        for (let i in values) {
            if (values[i] instanceof Array) {
                config_data.push(Config.getConfigData(values[i]));
            }
            else {
                /** @type {PublicRole} */
                let public_role = PublicRole.instanceFromApi(values[i]["roleid"], values[i]);
                // TODO: add role to be deleted if corresponding GuildRole doesn't exist
                public_role.guild_role = Guild.instance.roles.find(role => role.id === public_role.id);
                config_data.push(public_role);
            }
        }
        return config_data;
    }
}
