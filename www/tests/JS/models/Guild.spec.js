import sinon from "sinon";
import {expect} from "chai";
import {Guild, createGuild} from "../../../resources/assets/js/models/Guild";
import {GuildRole} from "../../../resources/assets/js/models/GuildRole";
import {GuildChannel} from "../../../resources/assets/js/models/GuildChannel";

describe("Guild", function () {
    let data;

    beforeEach(function () {
        data = {id: "id", name: "", icon: "icon"};
    });

    describe("instance", function () {
        it("should have a static 'instance' field that returns user-set static instance", function () {
            let guild = new Guild([], [], {id: "id", name: "", icon: "icon"});
            Guild.instance = guild;
            expect(Guild.instance).to.equal(guild);
        });
    });

    describe("constructor", function () {
        it("should take 'roles', 'channels', 'data' parameters in constructor", function () {
            expect(() => new Guild([], [], data)).to.not.throw();
        });

        it("should throw TypeError if constructor 'roles' parameter is not an Array of GuildRoles or empty", function () {
            let errorString = "roles parameter is not an Array of GuildRoles";
            let roles = [];
            expect(() => new Guild(roles, [], data)).to.not.throw();
            roles = [new GuildRole("id", "name")];
            expect(() => new Guild(roles, [], data)).to.not.throw();
            roles = [{}, {}];
            expect(() => new Guild(roles, [], data)).to.throw(TypeError, errorString);
            roles = {};
            expect(() => new Guild(roles, [], data)).to.throw(TypeError, errorString);
            roles = null;
            expect(() => new Guild(roles, [], data)).to.throw(TypeError, errorString);
        });

        it("should throw TypeError if constructor 'channels' parameter is not an Array of GuildChannels or empty", function () {
            let errorString = "channels parameter is not an Array of GuildChannels";
            let channels = [];
            expect(() => new Guild([], channels, data)).to.not.throw();
            channels = [new GuildChannel("id", "name")];
            expect(() => new Guild([], channels, data)).to.not.throw();
            channels = [{}, {}];
            expect(() => new Guild([], channels, data)).to.throw(TypeError, errorString);
            channels = {};
            expect(() => new Guild([], channels, data)).to.throw(TypeError, errorString);
            channels = null;
            expect(() => new Guild([], channels, data)).to.throw(TypeError, errorString);
        });

        it("should throw exception if constructor 'data' parameter does not have 'id', 'name', or 'icon' fields", function () {
            let errorString = "data parameter does not have id, name and icon fields";
            let dataParam = data;
            expect(() => new Guild([], [], dataParam)).to.not.throw();
            delete dataParam.id;
            expect(() => new Guild([], [], dataParam)).to.throw(TypeError, errorString);
            dataParam = data;
            delete dataParam.name;
            expect(() => new Guild([], [], dataParam)).to.throw(TypeError, errorString);
            dataParam = data;
            delete dataParam.icon;
            expect(() => new Guild([], [], dataParam)).to.throw(TypeError, errorString);
        });
    });

    describe("id", function () {
        it("returns id field set from constructor", function () {
            let guild = new Guild([], [], data);
            expect(guild.id).to.equal(data.id);
        });
    });

    describe("name", function () {
        it("returns name field set from constructor", function () {
            let guild = new Guild([], [], data);
            expect(guild.name).to.equal(data.name);
        });
    });

    describe("roles", function () {
        it("returns roles field set from constructor", function () {
            let roles = [new GuildRole("id", "name")];
            let guild = new Guild(roles, [], data);
            expect(guild.roles).to.equal(roles);
        });
    });

    describe("channels", function () {
        it("returns channels field set from constructor", function () {
            let channels = [new GuildChannel("id", "name")];
            let guild = new Guild([], channels, data);
            expect(guild.channels).to.equal(channels);
        });
    });

    describe("hasIcon()", function () {
        it("should return true if '_icon' field is set", function () {
            let guild = new Guild([], [], data);
            expect(guild.hasIcon()).to.be.true;
            data.icon = null;
            guild = new Guild([], [], data);
            expect(guild.hasIcon()).to.be.false;
            data.icon = undefined;
            guild = new Guild([], [], data);
            expect(guild.hasIcon()).to.be.false;
        });
    });

    describe("icon", function () {
        it("returns Discord URL with 'id and '_icon' fields in it set from constructor", function () {
            let guild = new Guild([], [], data);
            expect(guild.icon).to.equal(`https://cdn.discordapp.com/icons/${data.id}/${data.icon}.jpg`);
        });
    });

    describe("toString()", function () {
        it("returns name field when calling toString()", function () {
            let guild = new Guild([], [], data);
            expect(guild.toString()).to.equal(data.name);
        });
    });
});

describe("createGuild", function () {
    it("should take in required 'data' parameter and optional 'global' parameter");

    it("should set static Guild instance if 'global' parameter is true");

    it("should does not set static Guild instance if 'global' parameter is false");

    it("creates an array of GuildRoles if 'data' parameter has 'roles' field");

    it("creates an array of GuildChannels if 'data' parameter has 'channels' field");

    it("creates and freezes a new Guild instance");

    it("returns newly created Guild instance");
});
