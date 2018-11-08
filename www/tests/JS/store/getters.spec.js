import sinon from "sinon";
import {expect} from "chai";
import {getters} from "store/getters";
import {Config} from "models/Config";
import {ConfigData} from "models/ConfigData";

describe("getters", function () {
    describe("configInput", function () {
        let state;
        const storeName = "name";
        const response = "return value";

        before(function () {
            state = {
                config: new Config()
            }
        });

        it("should return as a function", function () {
            expect(getters.configInput(state)).to.be.instanceOf(Function);
        });

        it("should retrieve from state.config with storeName parameter if state.config is a Config instance", function () {
            let retrieveStub = sinon.stub(state.config, "retrieve");
            retrieveStub.withArgs(storeName).returns(response);

            expect(getters.configInput(state)(storeName)).to.equal(response);
            expect(retrieveStub.calledOnceWith(storeName)).to.be.true;
        });

        it("should create ConfigData instance with null value if state.config is not a Config instance", function () {
            state.config = {};
            let configData = sinon.stub(ConfigData, "instanceFromApi");
            configData.withArgs(storeName, null).returns(response);

            expect(getters.configInput(state)(storeName)).to.equal(response);
            expect(configData.calledOnceWith(storeName, null)).to.be.true;
        });
    });
});
