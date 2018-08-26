
export class PublicRoleGroup {
    constructor(id, name = "", role_limit = 1) {
        this.name = name;
        this.role_limit = role_limit;
        this._id = id.toString();
    }


    get id() {
        return this._id.toString();
    }

    toString() {
        return `Group ${this.id}`
    }
}

export class EmptyPublicRoleGroup extends PublicRoleGroup{
    toString() {
        return "No group"
    }
}