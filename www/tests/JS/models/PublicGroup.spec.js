import sinon from "sinon";
import {expect} from "chai";
import PublicGroup, {PublicGroupFactory} from "models/PublicGroup";
import configData from "../../../resources/assets/js/api/configData";
import {Config} from "../../../resources/assets/js/models/Config";
import {ConfigData} from "../../../resources/assets/js/models/ConfigData";

describe("PublicGroup", function () {
    let id;

    before(function () {
        id = "id";
    });

    describe("createInstance()", function () {
        it("returns new PublicGroup instance", function () {
            expect(PublicGroup.createInstance(id)).to.be.instanceof(PublicGroup);
        });

        it("has default value 1 for 'role_limit' parameter for createInstance()", function () {
            let group = PublicGroup.createInstance(id);
            expect(group.role_limit).to.equal(1);
        });

        it("sets 'role_limit' field from parameter", function () {
            const role_limit = 5;
            let group = PublicGroup.createInstance(id, role_limit);
            expect(group.role_limit).to.equal(role_limit);
        });

        it("has default value of empty string for 'name' parameter for createInstance()", function () {
            let group = PublicGroup.createInstance(id);
            expect(group.name).to.be.empty;
        });

        it("sets 'name' field from parameter", function () {
            const name = "name";
            let group = PublicGroup.createInstance(id, 1, name);
            expect(group.name).to.equal(name);
        });

        it("returns PublicGroup with role_limit and name fields in 'value' field", function () {
            let name = "name";
            let role_limit = 3;
            let group = PublicGroup.createInstance(id, role_limit, name);
            expect(group.value).to.eql({name, role_limit});
        });
    });

    describe("role_limit", function () {
        it("sets 'role_limit' field to 'value' field with 'role_limit' as key", function () {
            let group = PublicGroup.createInstance(5);
            group.role_limit = 10;
            expect(group.role_limit).to.equal(10);
            expect(group.value["role_limit"]).to.equal(10);
        });
    });

    describe("name", function () {
        it("sets 'name' field to 'value' field with 'name' as key", function () {
            let group = PublicGroup.createInstance(5);
            group.name = "name";
            expect(group.name).to.equal("name");
            expect(group.value["name"]).to.equal("name");
        });
    });

    describe("toString()", function () {
        it("returns 'name' field when calling toString() if it exists", function () {
            let group = PublicGroup.createInstance(5);
            group.name = "test";
            expect(group.toString()).to.equal("test");
        });

        it("returns 'Group ' and its id when calling toString() if name does not exist", function () {
            let group = PublicGroup.createInstance(5);
            expect(group.toString()).to.equal("Group 5");
        });
    });

});

describe("PublicGroupFactory", function () {
    let configData;
    let config;

    before(function () {
        configData = sinon.stub(ConfigData, "instanceFromApi");
        configData.returns("configData");

        config = sinon.stub(Config, "getConfigData");
        config.returns("config");
    });

    after(function () {
        ConfigData.instanceFromApi.restore();
        Config.getConfigData.restore();
    });

    describe("getConfigData()", function () {
        it("should throw TypeError if 'values' parameter is not an Array", function () {
            expect(() => PublicGroupFactory.getConfigData(null)).to.throw(TypeError, "'values' parameter is not an array");
            expect(() => PublicGroupFactory.getConfigData("")).to.throw(TypeError, "'values' parameter is not an array");
            expect(() => PublicGroupFactory.getConfigData({})).to.throw(TypeError, "'values' parameter is not an array");
            expect(() => PublicGroupFactory.getConfigData([])).to.not.throw();
        });

        it("should create an array of PublicGroups", function () {
            let values = [
                {
                    roleid: "id1"
                },
                {
                    roleid: "id2"
                }
            ];
            let publicGroups = PublicGroupFactory.getConfigData(values);
            expect(publicGroups).to.have.length(values.length);
            for (let i = 0; i < publicGroups.length; i++) {
                expect(publicGroups[i]).to.equal("configData");
            }
        });

        it("should create a Config instance instead of PublicGroup instance if specific array entry is an array itself", function () {
            let values = [
                [],
                {
                    roleid: "id2"
                }
            ];
            let publicGroups = PublicGroupFactory.getConfigData(values);
            expect(publicGroups).to.have.length(values.length);
            expect(publicGroups[0]).to.equal("config");
            expect(publicGroups[1]).to.equal("configData");
        });

        it("should throw exception if 'values' parameter doesn't have 'roleid' field when creating PublicGroup", function () {
            let values = [
                {
                }
            ];
            expect(() => PublicGroupFactory.getConfigData(values)).to.throw(TypeError, "'values' entry does not have roleid field");
        });
    });
});
