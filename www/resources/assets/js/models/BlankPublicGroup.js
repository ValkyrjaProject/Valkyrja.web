export class BlankPublicGroup {
    static instance;
    constructor() {
        if(!BlankPublicGroup.instance){
            BlankPublicGroup.instance = this;
        }

        return BlankPublicGroup.instance;
    }

    static singleton() {
        return new BlankPublicGroup;
    }

    get id() {
        return 0;
    }

    toString() {
        return "No group";
    }
}
