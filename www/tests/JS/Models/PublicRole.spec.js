import sinon from "sinon";
import {expect} from "chai";
import {PublicRole, PublicRoleFactory} from "../../../resources/assets/js/models/PublicRole";

describe("PublicRole", function () {
    it("should create new instance through createInstance() with 'id' and 'value' parameters");

    it("should create new instance with cloned original value for checking difference");

    it("has a createNewRole() function with 'id' and optional 'guild_role' parameters for creating a new role with default values");

    it("can associate new role with GuildRole");

    it("should throw TypeError if new role created has non-GuildRole instance in parameters");

    it("should have permission_level field value taken from 'value' field");

    it("should return permission_level field as integer");

    it("should set permission_level field value as integer");

    it("should set permission_level field value to 'value' field");

    it("should have public_id field value taken from 'value' field");

    it("should set public_id field value to 'value' field");

    it("should have guild_role field");

    it("should throw TypeError if setting guild_role field with a non-GuildRole instance");

    it("should display the guild_role.name when calling toString() if guild_role field is set");

    it("should display 'Not a valid role' when calling toString() if guild_role is unset");
});

describe("PublicRoleFactory", function () {
    it("should throw TypeError if getConfigData() 'values' parameter is not an Array");

    it("should create an array of PublicRoles from getConfigData()");

    it("should create a Config instance instead of PublicRole instance if specific array entry is an array itself");

    it("should throw exception if 'values' parameter for getConfigData() doesn't have 'roleid' field when creating PublicRole");

    it("should associate Guild role in getConfigData() with newly created PublicRole instance");

    it("should set role as deleted in getConfigData() if Guild role cannot be found for PublicRole");
});
