export class GuildChannel {
    constructor(id, name) {
        this._name = name;
        this._id = id;
    }

    get id() {
        return this._id;
    }

    set id(value) {
        this._id = value;
    }

    get name() {
        return this._name;
    }

    set name(value) {
        this._name = value;
    }

    toString() {
        return this.name;
    }
}

export function createGuildChannel({id, name}) {
    return Object.freeze(new GuildChannel(id, name));
}
