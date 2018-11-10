import sinon from "sinon";
import {expect} from "chai";
import {GuildRole, createGuildRole} from "../../../resources/assets/js/models/GuildRole";
import {createGuildChannel} from "../../../resources/assets/js/models/GuildChannel";

describe("GuildRole", function () {
    const id = "id";
    const name = "name";

    describe("constructor", function () {
        it("should take 'id' and 'name' parameters in constructor and set their fields", function () {
            let role = new GuildRole(id, name);
            expect(role.id).to.equal(id);
            expect(role.name).to.equal(name);
        });
    });

    describe("permission_level", function () {
        it("should parse input to 'permission_level' as integer", function () {
            let role = new GuildRole(id, name);
            role.permission_level = 123;
            expect(role.permission_level).to.equal(123);
            role.permission_level = "321";
            expect(role.permission_level).to.equal(321);
        });
    });

    describe("toString()", function () {
        it("should return name when calling toString()", function () {
            let role = new GuildRole(id, name);
            expect(role.toString()).to.equal(name);
        });
    });
});


describe("createGuildRole", function () {
    const id = "id";
    const name = "name";

    it("creates GuildRole as freezed object", function () {
        let role = createGuildRole({id, name});
        expect(Object.isFrozen(role)).to.be.true;
        expect(role).to.be.instanceof(GuildRole);
    });

    it("sets GuildChannel id and name correctly", function () {
        let role = createGuildRole({id, name});
        expect(role.id).to.equal(id);
        expect(role.name).to.equal(name);
    });
});
