export class GuildRole {
    constructor(id, name) {
        this.id = id;
        this.name = name;
    }

    get permission_level() {
        return this._permission_level;
    }

    set permission_level(level) {
        this._permission_level = parseInt(level);
    }

    toString() {
        return this.name;
    }
}

export function createGuildRole({id, name}) {
    return Object.freeze(new GuildRole(id, name));
}
