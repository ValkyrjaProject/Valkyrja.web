import sinon from "sinon";
import {expect} from "chai";
import {ConfigData} from "../../../resources/assets/js/models/ConfigData";

describe("ConfigData", function () {
    describe("instanceFromApi()", function () {
        it("should have static instanceFromApi() that takes 'id' and 'value' parameters");

        it("should return new ConfigData instance when calling instanceFromApi()");

        it("should have set 'id', 'value', and 'original_value' fields when returning from instanceFromApi()");

        it("should clone value from instanceFromApi() and set in original_value field");
    });

    describe("newInstance()", function () {
        it("should have static newInstance() that takes 'id' and 'value' parameters");

        it("should return new ConfigData instance when calling newInstance()");

        it("should have set 'id' and 'value' fields but undefined 'original_value' field when returning from newInstance()");
    });

    describe("hasChanged()", function () {
        it("should return true if data has changed when calling hasChanged()");

        it("should return false if data has not changed when calling hasChanged()");
    });

    describe("toString()", function () {
        it("returns 'value' as string if set, otherwise empty string when calling toString()");
    });
});
