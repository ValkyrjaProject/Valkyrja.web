import {expect} from "chai";
import {EmptyData} from "../../../resources/assets/js/models/EmptyData";


describe("EmptyData", function () {
    it("should only create one instance", function () {
        let group = new EmptyData;
        expect(group).to.equal(new EmptyData);
        expect(group).to.equal(EmptyData.instance);
        expect(group).to.equal(EmptyData.singleton());
    });
});
