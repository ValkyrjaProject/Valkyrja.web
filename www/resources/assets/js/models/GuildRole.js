export class GuildRole {
    constructor(id, name) {
        this.id = id;
        this.name = name;
        // TODO: Add all GuildRole fields
        /*this.permission_level = permission_level;
        this.public_id = public_id;
        this.logging_ignored = logging_ignored;
        this.antispam_ignored = antispam_ignored;*/
    }

    get permission_level() {
        return this._permissionLevel;
    }

    set permission_level(level) {
        this._permissionLevel = parseInt(level);
    }

    toString() {
        return this.name;
    }
}

export function createGuildRole({id, name}) {
    return Object.freeze(new GuildRole(id, name));
}
