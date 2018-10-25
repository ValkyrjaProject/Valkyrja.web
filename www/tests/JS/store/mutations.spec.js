import sinon from "sinon";
import {expect} from "chai";
import {state, mutations} from "store/mutations";

describe("state", function () {
    it("should have empty array 'guilds'", function () {
        expect(state.guilds).to.deep.equal([]);
    });

    it("should have empty object 'guild'", function () {
        expect(state.guild).to.deep.equal({});
    });

    it("should have object 'user' with name and avatar fields", function () {
        expect(state.user).to.have.all.keys("name", "avatar");
    });

    it("should user.name field be null", function () {
        expect(state.user.name).to.be.null;
    });

    it("should user.avatar field be null", function () {
        expect(state.user.avatar).to.be.null;
    });
});

describe("mutations", function () {
    describe("ADD_GUILDS", function () {
        it("should create a Guild for each guild in guilds parameter and add the list to state.guilds");

        it("should set empty list to state.guilds if no guilds exists");
    });

    describe("ADD_CONFIG", function () {
        it("should create a global Guild and set it to state.guild");

        it("should create a Config and set it to state.config");

        it("should call Config addGuildData() with Guild instance parameter");
    });

    describe("ADD_USER", function () {
        it("should set state.user to user parameter");
    });

    describe("INITIALIZE_USER", function () {
        it("should set unserialized JSON data to state.user from lscache.get('user') if it exists");
    });

    describe("CHANGE_CONFIG", function () {
        it("should have configData parameter with storeName and value fields");

        it("should throw TypeError if storeName and value fields doesn't exist");

        it("should call state.config.change with configData.storeName as first parameter and configData.value as second parameter");
    });

    describe("ADD_ARRAY_OBJECT", function () {
        it("should find array from state.config based on payload.id parameter");

        it("should push payload.value to the array's value field if it is a ConfigData and it's value field is an Array");

        it("should create a new ConfigData instance from newInstance() function if payload.value is a ConfigData field");

        it("should not create a new ConfigData instance if the array's value field if it is a ConfigData and it's value field is an Array");

        it("should save new ConfigData instance to state.config.config_data with key being payload.id");

        it("should fail silently if array can't be found and payload.value isn't a ConfigData instance");

        it("should fail silently if array.value is not an Array and payload.value isn't a ConfigData instance");

        it("should fail silently if array is not a ConfigData instance and payload.value isn't a ConfigData instance");
    });
});
