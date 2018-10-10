import sinon from "sinon";
import {expect} from "chai";
import {retrieveConfig, retrieveGuilds, retrieveUser, initializeUser, changeConfig} from "store/actions";

describe("actions", function () {
    describe("retrieveGuilds", function () {
        it("commits 'ADD_GUILDS' with response data if configData.getGuilds() is successful");

        it("commits 'API_ERROR' with error if configData.getGuilds() failed");
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
