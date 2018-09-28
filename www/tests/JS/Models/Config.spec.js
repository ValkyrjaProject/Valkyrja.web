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

        for (let i in configValues) {
            let obj = {id: i, value: configValues[i]};
            stub.withArgs(i.toString(), configValues[i]).returns(obj);
        }
        Config.getConfigData(configValues);
        expect(pgFactory.calledOnce).to.equal(true);
    });

    it("should create a PublicRole if index is 'roles'", function () {
        configValues["roles"] = "roles";
        let prFactory = sinon.stub(PublicRoleFactory, "getConfigData");
        prFactory.returns(configValues["roles"]);

        for (let i in configValues) {
            let obj = {id: i, value: configValues[i]};
            stub.withArgs(i.toString(), configValues[i]).returns(obj);
        }
        Config.getConfigData(configValues);
        expect(prFactory.calledOnce).to.equal(true);
    });

    it("should create and store configData in 'config_data' variable", function () {
        let testData = "test";
        let getConfigDataMock = sinon.stub(Config, "getConfigData");
        getConfigDataMock.returns(testData);
        let response = Config.instanceFromApi(configValues);
        expect(getConfigDataMock.calledOnce).to.equal(true);
        expect(response.config_data).to.equal(testData);
    });
});
