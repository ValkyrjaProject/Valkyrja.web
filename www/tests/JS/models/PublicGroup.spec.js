import sinon from "sinon";
import {expect} from "chai";
import {PublicGroup, PublicGroupFactory} from "../../../resources/assets/js/models/PublicGroup";

describe("PublicGroup", function () {
    it("returns new PublicGroup instance when calling createInstance()");

    it("should take in optional parameters 'role_limit' and 'name' when calling createInstance()");

    it("has default value 1 for 'role_limit' parameter for createInstance()");

    it("has default value '' for 'name' parameter for createInstance()");

    it("returns PublicGroup with empty object in 'value' field when calling createInstance()");

    it("sets 'role_limit' field to 'value' field under 'role_limit' key");

    it("returns 'role_limit' field from 'value' field under 'role_limit' key");

    it("sets 'name' field to 'value' field under 'name' key");

    it("returns 'name' field from 'value' field under 'name' key");

    it("returns 'name' field when calling toString() if it exists");

    it("returns 'Group ' and its id when calling toString() if name does not exist");
});

describe("PublicGroupFactory", function () {
    it("should throw TypeError if getConfigData() 'values' parameter is not an Array");

    it("should create an array of PublicGroups from getConfigData()");

    it("should create a Config instance instead of PublicGroup instance if specific array entry is an array itself");

    it("should throw exception if 'values' parameter for getConfigData() doesn't have 'roleid' field when creating PublicGroup");
});
