import {ConfigData} from "./ConfigData";
import {PublicRole, PublicRoleFactory} from "./PublicRole";
import {PublicGroupFactory} from "./PublicGroup";
import {Channel, ChannelFactory} from "./Channel";
import {ProfileFactory} from "./Profile";
import {CustomCommandFactory} from "./CustomCommand";
import {ReactionRoleFactory} from "./ReactionRole";

/**
 * Main class containing a list of only ConfigData instances and lists of ConfigData instances
 */
export class Config {
    /** @type {Object<ConfigData>} */
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
     * @returns {Object<ConfigData>}
     */
    static getConfigData(values) {
        let config_data = {};
        for (let i in values) {
            let configInstance;
            if (i === "roles") {
                configInstance = PublicRoleFactory.getConfigData(values[i]);
            }
            else if (i === "channels") {
                configInstance = ChannelFactory.getConfigData(values[i]);
            }
            else if (i === "role_groups") {
                configInstance = PublicGroupFactory.getConfigData(values[i]);
            }
            else if (i === "profile_options") {
                configInstance = ProfileFactory.getConfigData(values[i]);
            }
            else if (i === "custom_commands") {
                configInstance = CustomCommandFactory.getConfigData(values[i]);
            }
            else if (i === "reaction_roles") {
                configInstance = ReactionRoleFactory.getConfigData(values[i]);
            }
            else if (values[i] instanceof Array) {
                configInstance = this.getConfigData(values[i]);
            }
            else {
                configInstance = values[i];
            }
            /** @member {ConfigData}*/
            let arrayConfig = ConfigData.instanceFromApi(i, configInstance);
            config_data[arrayConfig.id] = arrayConfig;
        }
        return config_data;
    }

    /**
     *
     * @param {Guild} guild
     * @returns {Config}
     */
    addGuildData(guild) {
        let roles = this.find("roles");
        if (roles && roles.value instanceof Array) {
            this.addRoles(guild, roles);
        }
        let channels = this.find("channels");
        if (channels && channels.value instanceof Array) {
            this.addChannels(guild, channels);
        }
        return this;
    }

    addChannels(guild, channels) {
        // retrieves all roles that does not exist in config
        let channelsToAdd = guild.channels.filter(guildChannel => {
            return channels.value.filter(channel => channel.id === guildChannel.id).length === 0;
        });
        for (let channel of channelsToAdd) {
            channels.value.push(Channel.createNewChannel(channel.id, channel));
        }
    }

    addRoles(guild, roles) {
        // retrieves all roles that does not exist in config
        let rolesToAdd = guild.roles.filter(guildRole => {
            return roles.value.filter(role => role.id === guildRole.id).length === 0;
        });
        for (let role of rolesToAdd) {
            roles.value.push(PublicRole.createNewRole(role.id, role));
        }
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

    /**
     * Retrieves the config matching a specific data
     * @param id
     * @returns {ConfigData}
     */
    find(id) {
        if (this.config_data.hasOwnProperty(id)) {
            return this.config_data[id];
        }
        return null;
    }

    /**
     * @param id
     * @param {ConfigData} configData
     */
    add(id, configData) {
        if (!(configData instanceof ConfigData)) {
            throw new TypeError("Adding new config values must be of type ConfigData");
        }
        this.config_data[id] = configData;
    }

    getChanges() {
        let changes = {};
        /** @member {ConfigData} config */
        for(let key of Object.keys(this.config_data)) {
            let obj = this.config_data[key].getChanged();
            if (obj && obj.hasOwnProperty(key)) {
                console.log(key, obj[key]);
                changes[key] = obj[key];
            }
        }
        return changes;
    }
}




