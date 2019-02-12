import {ConfigData} from "./ConfigData";
import {Config} from "./Config";
import {Guild} from "./Guild";
import {GuildChannel} from "./GuildChannel";

export class Channel extends ConfigData {

    /**
     * @param id
     * @param {GuildChannel} guild_channel
     * @returns {Channel}
     */
    static createNewChannel(id, guild_channel = null) {
        let newChannel = new Channel();
        newChannel.id = id;
        newChannel.value = {
            channelid: id,
            ignored: 0,
            temporary: 0,
        };
        if (guild_channel) {
            newChannel.guild_channel = guild_channel;
        }
        newChannel.original_value = _.cloneDeep(newChannel.value);
        return newChannel;
    }

    get ignored() {
        return !!parseInt(this.value["ignored"]);
    }

    set ignored(ignored) {
        this.value["ignored"] = parseInt(ignored);
    }

    get temporary() {
        return parseInt(this.value["temporary"]);
    }

    set temporary(ignored) {
        this.value["temporary"] = !!parseInt(ignored);
    }

    get channelid() {
        return this.value["channelid"];
    }

    set channelid(id) {
        this.value["channelid"] = id;
    }

    /**
     * @returns {GuildChannel}
     */
    get guild_channel() {
        return this._guild_channel;
    }

    /**
     * @param {GuildChannel} channel
     */
    set guild_channel(channel) {
        if (channel === undefined || !(channel instanceof GuildChannel)) {
            log.warn("Channel is not of type GuildChannel:", channel);
            throw new TypeError("Channel is not of type GuildChannel");
        }
        this._guild_channel = channel;
        return this;
    }

    toString() {
        if (this.guild_channel) {
            return this.guild_channel.name;
        }
        return "Not a valid channel";
    }
}

export class ChannelFactory {
    /**
     * @param {Array} values
     * @returns {Array<Channel>}
     */
    static getConfigData(values) {
        let config_data = [];
        for (let i in values) {
            if (values[i] instanceof Array) {
                config_data.push(Config.getConfigData(values[i]));
            }
            else {
                /** @type {Channel} */
                let channel = Channel.instanceFromApi(values[i]["channelid"], values[i]);
                // TODO: set channel to be deleted if corresponding GuildChannel doesn't exist
                log.warn("Channel is not being marked for deletion if GuildChannel doesn't exist");
                let guildChannel = Guild.instance.channels.find(guildChannel => guildChannel.id === channel.id);
                if (guildChannel) {
                    channel.guild_channel = guildChannel;
                }
                config_data.push(channel);
            }
        }
        return config_data;
    }
}
