import sinon from "sinon";
import {expect} from "chai";
import {Guild, createGuild} from "../../../resources/assets/js/models/Guild";

describe("Guild", function () {
    it("should have a static 'instance' field that returns user-set static instance");

    it("should be able to set static Guild instance to 'instance' field");

    it("should take 'roles', 'channels', 'data' parameters in constructor");

    it("should throw TypeError if constructor 'roles' parameter is not an Array of GuildRoles or null");

    it("should throw TypeError if constructor 'channels' parameter is not an Array of GuildChannels or null");

    it("should throw exception if constructor 'data' parameter does not have 'id', 'name', or 'icon' fields");

    it("has a get 'name' field for returning private field '_name'");

    it("has a get 'id' field for returning private field '_id'");

    it("should return true for hasIcon() if '_icon' field is set");

    it("returns Discord URL from 'icon' field with 'id and '_icon' fields in it");

    it("has a get 'roles' field for returning private field '_roles'");

    it("has a get 'channels' field for returning private field '_channels'");

    it("returns name field when calling toString()");
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
