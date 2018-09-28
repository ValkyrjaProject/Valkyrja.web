import {expect} from "chai";
import {BlankPublicGroup} from "../../../resources/assets/js/models/BlankPublicGroup";

describe("BlankPublicGroup", function () {
    it("should only create one instance", function () {
        let group = new BlankPublicGroup;
        expect(group).to.equal(new BlankPublicGroup);
        expect(group).to.equal(BlankPublicGroup.instance);
    });

    it("should return 0 for id field", function () {
        let group = new BlankPublicGroup;
        expect(group.id).to.equal(0);
    });

    it("should return 'No Group' when calling toString()", function () {
        let group = new BlankPublicGroup;
        expect(group.toString()).to.equal("No group");
    });
});
