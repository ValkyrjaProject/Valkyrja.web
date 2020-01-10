import {ConfigData} from "./ConfigData";

export default class EmojiRole extends ConfigData {
    role;
    emoji;
    // TODO: Change so it takes in role and saves that and emoji, but has getter for value.id and value.emoji
    static instanceFromApi(role, emoji) {
        const emojiRole = new this;
        emojiRole.role = role;
        emojiRole.emoji = emoji;
        return emojiRole;
    }

    get value() {
        return {
            id: this.role.id,
            emoji: this.emoji
        };
    }

    toString() {
        return this.role.toString();
    }
}
