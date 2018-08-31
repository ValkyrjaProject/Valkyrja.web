export default class PublicGroup {
    static createInstance(id) {
        let group = new PublicGroup();
        group.setId(id);
        return group;
    }
    static createNameInstance(id, name) {
        let group = new PublicGroup();
        group.setId(id);
        group.name = name;
        return group;
    }

    setId(id) {
        this.id = parseInt(id);
    }

    setName(name) {
        this.name = name;
    }

    get value() {
        return this.id;
    }

    toString() {
        if (this.name) {
            return this.name;
        }
        return "Group " + this.id;
    }
}
