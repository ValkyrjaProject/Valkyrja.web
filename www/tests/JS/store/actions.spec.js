import sinon from "sinon";
import {expect, assert} from "chai";
import {retrieveConfig, retrieveGuilds, retrieveUser, initializeUser, changeConfig} from "store/actions";
import configData from "api/configData";

describe("actions", function () {
    describe("retrieveGuilds", function () {
        it("commits 'ADD_GUILDS' with response data if configData.getGuilds() is successful", async function () {
            let getGuilds = sinon.stub(configData, "getGuilds");
            const response = {data: "data"};
            getGuilds.resolves(response);
            let payload = {commit: sinon.stub()};
            await retrieveGuilds(payload);
            expect(getGuilds.calledOnce).to.be.true;
            expect(payload.commit.calledWith("ADD_GUILDS", response.data), "it commits ADD_GUILDS").to.be.true;
        });

        it("commits 'API_ERROR' with error if configData.getGuilds() failed", async () => {
            let getGuilds = sinon.stub(configData, "getGuilds");
            const error = new Error();
            getGuilds.rejects(error);
            let payload = {commit: sinon.stub()};
            await retrieveGuilds(payload).catch(() => {});
            expect(getGuilds.calledOnce).to.be.true;
            expect(payload.commit.calledWith("API_ERROR", error), "it commits API_ERROR").to.be.true;
        });
    });

    describe("retrieveConfig", function () {
        it("commits 'ADD_CONFIG' with response data if configData.getServerConfig() is successful");

        it("commits 'API_ERROR' with error if configData.getServerConfig() failed");
    });

    describe("retrieveUser", function () {
        it("commits 'ADD_USER' with response data if configData.getUser() is successful");

        it("commits 'API_ERROR' with error if configData.getUser() failed");
    });

    describe("initializeUser", function () {
        it("commits 'INITIALIZE_USER'");
    });

    describe("changeConfig", function () {
        it("throws TypeError if configData doesn't have 'storeName' or 'value' parameters");

        it("commits 'CHANGE_CONFIG' if configData has 'storeName' or 'value' parameters");
    });
});
