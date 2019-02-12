import {ConfigData} from "./ConfigData";
import {Config} from "./Config";
import {Guild} from "./Guild";
import {GuildRole} from "./GuildRole";

export class PublicRole extends ConfigData {

    /**
     * @param id
     * @param {GuildRole} guild_role
     * @returns {PublicRole}
     */
    static createNewRole(id, guild_role = null) {
        let newRole = new this();
        newRole.id = id;
        newRole.value = {
            roleid: id,
            permission_level: 0,
            public_id: 0,
            logging_ignored: 0,
            antispam_ignored: 0,
            level: 0,
        };
        if (guild_role) {
            newRole.guild_role = guild_role;
        }
        newRole.original_value = _.cloneDeep(newRole.value);
        return newRole;
    }

    get permission_level() {
        return this.value["permission_level"];
    }

    set permission_level(level) {
        this.value["permission_level"] = parseInt(level);
    }

    get level() {
        return this.value["level"];
    }

    set level(level) {
        this.value["level"] = parseInt(level);
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
        return this._guild_role;
    }

    /**
     * @param {GuildRole} role
     */
    set guild_role(role) {
        if (role === undefined || !(role instanceof GuildRole)) {
            log.warn("Role is not of type GuildRole:", role);
            throw new TypeError("Role is not of type GuildRole");
        }
        this._guild_role = role;
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
                // TODO: set role to be deleted if corresponding GuildRole doesn't exist
                log.warn("PublicRole is not marked for deletion if GuildRole doesn't exist");
                let guildRole = Guild.instance.roles.find(role => role.id === public_role.id);
                if (guildRole) {
                    public_role.guild_role = guildRole;
                }
                config_data.push(public_role);
            }
        }
        return config_data;
    }
}
