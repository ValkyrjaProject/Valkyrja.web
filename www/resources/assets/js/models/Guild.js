import {createGuildRole} from "./GuildRole";
import {createGuildChannel} from "./GuildChannel";
import {GuildRole} from "./GuildRole";
import {GuildChannel} from "./GuildChannel";

export class Guild {
    static get instance() {
        return Guild._instance;
    }

    static set instance(guild) {
        Guild._instance = guild;
    }

    /**
     *
     * @param {Array<GuildRole>} roles
     * @param {Array<GuildChannel>} channels
     * @param data
     */
    constructor(roles, channels, data) {
        if (!Array.isArray(roles) || (roles.length > 0 && roles.some(r => !(r instanceof GuildRole)))) {
            let error = new TypeError("roles parameter is not an Array of GuildRoles");
            throw error;
        }
        if (!Array.isArray(channels) || (channels.length > 0 && channels.some(r => !(r instanceof GuildChannel)))) {
            let error = new TypeError("channels parameter is not an Array of GuildChannels");
            throw error;
        }
        if (!(data instanceof Object) || !data.hasOwnProperty("id") || !data.hasOwnProperty("name") || !data.hasOwnProperty("icon")) {
            let error = new TypeError("data parameter does not have id, name and icon fields");
            throw error;
        }
        this._roles = roles;
        this._channels = channels;
        this._id = data.id;
        this._name = data.name;
        this._icon = data.icon;
    }

    get name() {
        return this._name;
    }

    get id() {
        return this._id;
    }

    /**
     * @returns {boolean} if icon id exists
     */
    hasIcon() {
        return this._icon !== null && this._icon !== undefined;
    }

    get icon() {
        if (this._icon.startsWith("http")) {
            return this._icon;
        }
        return `https://cdn.discordapp.com/icons/${this.id}/${this._icon}.jpg`;
    }

    get roles() {
        return this._roles;
    }

    get channels() {
        return this._channels;
    }

    toString() {
        return this.name;
    }

    static createGuild(data, global = false) {
        let roles = [];
        if (data.hasOwnProperty("roles")) {
            data.roles.forEach(role => {
                roles.push(createGuildRole(role));
            });
        }

        let channels = [];
        if (data.hasOwnProperty("channels")) {
            data.channels.forEach(channel => {
                channels.push(createGuildChannel(channel));
            });
        }
        const guild = Object.freeze(new Guild(roles, channels, data));
        if (global) {
            Guild.instance = guild;
        }
        return guild;
    }

}
