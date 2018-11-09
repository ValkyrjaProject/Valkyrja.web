import sinon from "sinon";
import {expect, assert} from "chai";
import {retrieveConfig, retrieveGuilds, retrieveUser, initializeUser, changeConfig} from "store/actions";
import configData from "api/configData";

describe("actions", function () {
    describe("retrieveGuilds", function () {
        let getGuilds;

        before(function () {
            getGuilds = sinon.stub(configData, "getGuilds");
        });

        afterEach(function () {
            getGuilds.reset();
        });

        after(function () {
            getGuilds.resetBehavior();
        });

        it("commits 'ADD_GUILDS' with response data if configData.getGuilds() is successful", async function () {
            const response = {data: "data"};
            getGuilds.resolves(response);
            let payload = {commit: sinon.stub()};
            await retrieveGuilds(payload);
            expect(getGuilds.calledOnce).to.be.true;
            expect(payload.commit.calledWith("ADD_GUILDS", response.data), "it commits ADD_GUILDS").to.be.true;
        });

        it("commits 'API_ERROR' with error if configData.getGuilds() failed", async () => {
            const error = new Error();
            getGuilds.rejects(error);
            let payload = {commit: sinon.stub()};
            await retrieveGuilds(payload).catch(() => {});
            expect(getGuilds.calledOnce).to.be.true;
            expect(payload.commit.calledWith("API_ERROR", error), "it commits API_ERROR").to.be.true;
        });
    });

    describe("retrieveConfig", function () {
        let getServerConfig;

        before(function () {
            getServerConfig = sinon.stub(configData, "getServerConfig");
        });

        afterEach(function () {
            getServerConfig.reset();
        });

        after(function () {
            getServerConfig.resetBehavior();
        });

        it("commits 'ADD_CONFIG' with response data if configData.getServerConfig() is successful", async () => {
            const response = {data: "data"};
            getServerConfig.resolves(response);
            let payload = {commit: sinon.stub()};
            await retrieveConfig(payload);
            expect(getServerConfig.calledOnce).to.be.true;
            expect(payload.commit.calledWith("ADD_CONFIG", response.data), "it commits ADD_CONFIG").to.be.true;
        });

        it("commits 'API_ERROR' with error if configData.getServerConfig() failed", async () => {
            const error = new Error();
            getServerConfig.rejects(error);
            let payload = {commit: sinon.stub()};
            await retrieveConfig(payload).catch(() => {});
            expect(getServerConfig.calledOnce, "config.getServerConfig() called once").to.be.true;
            expect(payload.commit.calledWith("API_ERROR", error), "it commits API_ERROR").to.be.true;
        });
    });

    describe("retrieveUser", function () {
        let getUser;

        before(function () {
            getUser = sinon.stub(configData, "getUser");
        });

        afterEach(function () {
            getUser.reset();
        });

        after(function () {
            getUser.resetBehavior();
        });

        it("commits 'ADD_USER' with response data if configData.getUser() is successful", async () => {
            const response = {data: "data"};
            getUser.resolves(response);
            let payload = {commit: sinon.stub()};
            await retrieveUser(payload);
            expect(getUser.calledOnce).to.be.true;
            expect(payload.commit.calledWith("ADD_USER", response.data), "it commits ADD_USER").to.be.true;
        });

        it("commits 'API_ERROR' with error if configData.getUser() failed", async () => {
            const error = new Error();
            getUser.rejects(error);
            let payload = {commit: sinon.stub()};
            await retrieveUser(payload).catch(() => {});
            expect(getUser.calledOnce, "config.getUser() called once").to.be.true;
            expect(payload.commit.calledWith("API_ERROR", error), "it commits API_ERROR").to.be.true;
        });
    });

    describe("initializeUser", function () {
        it("commits 'INITIALIZE_USER'", function () {
            let payload = {commit: sinon.stub()};
            initializeUser(payload);
            expect(payload.commit.calledOnceWith("INITIALIZE_USER")).to.be.true;
        });
    });

    describe("changeConfig", function () {
        it("throws TypeError if configData doesn't have 'storeName' and 'value' parameters", function () {
            let payload = {commit: sinon.stub()};
            let configData = {storeName: "name"};
            expect(() => changeConfig(payload, configData)).to.throw(TypeError, "CHANGE_CONFIG: missing property 'storeName' or 'value'");
            configData = {value: "name"};
            expect(() => changeConfig(payload, configData)).to.throw(TypeError, "CHANGE_CONFIG: missing property 'storeName' or 'value'");
            configData = {storeName: "name", value: "name"};
            expect(() => changeConfig(payload, configData)).to.not.throw();
        });

        it("commits 'CHANGE_CONFIG' with configData if configData has 'storeName' or 'value' parameters", function () {
            let payload = {commit: sinon.stub()};
            let configData = {storeName: "name", value: "name"};
            changeConfig(payload, configData);
            expect(payload.commit.calledOnceWith("CHANGE_CONFIG", configData));
        });
    });
});
