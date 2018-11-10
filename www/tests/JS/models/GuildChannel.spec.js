import sinon from "sinon";
import {expect} from "chai";
import {GuildChannel, createGuildChannel} from "../../../resources/assets/js/models/GuildChannel";

describe("GuildChannel", function () {
    const id = "id";
    const name = "name";

    describe("constructor", function () {
        it("should take 'id' and 'name' parameters in constructor", function () {
            let channel = new GuildChannel(id, name);
            expect(channel.id).to.equal(id);
            expect(channel.name).to.equal(name);
        });
    });

    describe("toString()", function () {
        it("should return name field when calling toString()", function () {
            let channel = new GuildChannel(id, name);
            expect(channel.toString()).to.equal(name);
        });
    });
});

describe("createGuildChannel", function () {
    const id = "id";
    const name = "name";

    it("creates GuildChannel as freezed object", function () {
        let channel = createGuildChannel({id, name});
        expect(Object.isFrozen(channel)).to.be.true;
        expect(channel).to.be.instanceof(GuildChannel);
    });

    it("sets GuildChannel id and name correctly", function () {
        let channel = createGuildChannel({id, name});
        expect(channel.id).to.equal(id);
        expect(channel.name).to.equal(name);
    });
});
