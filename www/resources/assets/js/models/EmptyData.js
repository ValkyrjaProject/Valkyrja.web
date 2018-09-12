export class EmptyData {
    static instance;
    constructor() {
        if(!EmptyData.instance){
            EmptyData.instance = this;
        }

        return EmptyData.instance;
    }

    static singleton() {
        return new EmptyData;
    }
}
