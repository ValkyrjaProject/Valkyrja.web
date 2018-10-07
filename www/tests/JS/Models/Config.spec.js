import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import {Config} from "../../../resources/assets/js/models/Config";
import {ConfigData} from "../../../resources/assets/js/models/ConfigData";
import {PublicGroupFactory} from "../../../resources/assets/js/models/PublicGroup";
import {PublicRoleFactory} from "../../../resources/assets/js/models/PublicRole";

describe("Config", function () {
    let configValues;
    let stub;

    beforeEach(function () {
        stub = sinon.stub(ConfigData, "instanceFromApi");
        configValues = [
            "test1",
            "test2",
            "test3",
        ];
    });

    afterEach(function () {
        stub.restore();
    });

    it("should iterate through all configValues", function () {
        stub.returns("id");
        Config.getConfigData(configValues);
        for (let i = 0; i < configValues.length; i++) {
            expect(stub.withArgs(i.toString(), configValues[i]).calledOnce).to.equal(true);
        }
    });

    it("should return an object of ConfigData objects", function () {
        let response = {};
        for (let i = 0; i < configValues.length; i++) {
            let obj = {id: i, value: configValues[i]};
            stub.withArgs(i.toString(), configValues[i]).returns(obj);
            response[i] = obj;
        }
        expect(Config.getConfigData(configValues)).to.deep.equal(response);
    });

    it("should recursively add ConfigData of fields in arrays", function () {
        let response = {};
        let nestedArray = ["nested array value 1", "nested array value 2"];
        configValues.push(nestedArray);
        for (let i = 0; i < configValues.length; i++) {
            let obj = {id: i, value: configValues[i]};
            if (configValues[i] instanceof Array) {
                let returnObj = {};
                for (let j = 0; j < configValues[i].length; j++) {
                    obj = {id: j, value: configValues[i][j]};
                    stub.withArgs(j.toString(), configValues[i][j]).returns(obj);
                    returnObj[j] = obj;
                }
                obj = {id: i, value: returnObj};
                stub.withArgs(i.toString(), returnObj).returns(obj);
            }
            else {
                stub.withArgs(i.toString(), configValues[i]).returns(obj);
            }
            response[i] = obj;
        }
        expect(Config.getConfigData(configValues)).to.deep.equal(response);
    });

    it("should create a PublicGroup if index is 'role_groups'", function () {
        configValues["role_groups"] = "role_groups";
        let pgFactory = sinon.stub(PublicGroupFactory, "getConfigData");
        pgFactory.returns(configValues["role_groups"]);

        stubConfigValues();
        Config.getConfigData(configValues);
        expect(pgFactory.calledOnce).to.equal(true);
        pgFactory.restore();
    });

    it("should create a PublicRole if index is 'roles'", function () {
        configValues["roles"] = "roles";
        let prFactory = sinon.stub(PublicRoleFactory, "getConfigData");
        prFactory.returns(configValues["roles"]);

        stubConfigValues();
        Config.getConfigData(configValues);
        expect(prFactory.calledOnce).to.equal(true);
        prFactory.restore();
    });

    it("should create and store configData in 'config_data' variable", function () {
        let testData = "test";
        let getConfigDataMock = sinon.stub(Config, "getConfigData");
        getConfigDataMock.returns(testData);
        let response = Config.instanceFromApi(configValues);
        expect(getConfigDataMock.calledOnce).to.equal(true);
        expect(response.config_data).to.equal(testData);
        getConfigDataMock.restore();
    });

    it("should find stored config data", function () {
        configValues["testData"] = "testValue";

        stubConfigValues();
        let config = Config.instanceFromApi(configValues);
        expect(config.find("testData")).to.deep.equal({id: "testData", value: configValues["testData"]});
    });

    it("should return null if no data is found", function () {
        stubConfigValues();
        let config = Config.instanceFromApi(configValues);
        expect(config.find("non-existant id")).to.equal(null);
    });

    it("should have retrieve function be an alias for find", function () {
        stubConfigValues();
        let config = Config.instanceFromApi(configValues);
        let find = sinon.stub(config, "find");
        config.retrieve("test");
        expect(find.withArgs("test").calledOnce).to.equal(true);
        find.restore();
    });

    function stubConfigValues() {
        for (let i in configValues) {
            let obj = {id: i, value: configValues[i]};
            stub.withArgs(i.toString(), configValues[i]).returns(obj);
        }
    }

    it("should add data to config_data through add function");

    it("should throw TypeError when calling add function without ConfigData instance");

    it("should add ConfigErrors to error array field");

    it("should associate ConfigErrors with ConfigData of the same id");

    it("should have same ConfigError instance in errors array field as a specific config data's errors field");

    it("should return specific ConfigErrors based on id");

    it("should be able to remove specific ConfigError instance");
});
