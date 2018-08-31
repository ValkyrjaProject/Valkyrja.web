export class GuildChannel {
    constructor(id, name) {
        this.id = id;
        this._name = name;
    }

    get name() {
        return "#" + this._name;
    }

    toString() {
        return this._name;
    }
}

export function createGuildChannel({id, name}) {
    return Object.freeze(new GuildChannel(id, name));
}
