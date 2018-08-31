import {createGuildRole} from "./GuildRole";
import {createGuildChannel} from "./GuildChannel";

export class Guild {
    static get instance() {
        return Guild._instance;
    }

    static set instance(guild) {
        Guild._instance = guild;
    }

    constructor(roles, channels, data) {
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
}

export function createGuild(data, global = false) {
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
