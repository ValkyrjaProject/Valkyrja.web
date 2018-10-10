import sinon from "sinon";
import {expect} from "chai";
import {getters} from "store/getters";

describe("getters", function () {
    describe("configInput", function () {
        it("should return as a function that takes in storeName");
        it("should retrieve from state.config with storeName parameter if state.config is a Config instance");
        it("should create ConfigData instance with null value if state.config is not a Config instance");
        it("should return null if ConfigData does not exist in state.config");
        it("should return ConfigData instance if it exists in state.config");
    });
});
