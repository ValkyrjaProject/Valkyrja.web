export default class EmojiRole {
    /**
     *
     * @param {String} id
     * @param {GuildRole} role
     */
    static createInstance(id, role) {
        let reactionRole = new EmojiRole;
        reactionRole.id = id;
        reactionRole.role = role;
    }
}
