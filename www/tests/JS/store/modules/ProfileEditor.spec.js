import sinon from "sinon";
import {expect} from "chai";
import {mutations, actions, getters} from "store/modules/ProfileEditor";


describe("ProfileEditor Vuex module", function () {
    describe("state", function () {
        it("should set selectedProfile as 'null'");
    });

    describe("mutations", function () {
        describe("addProfile", function () {
            it("commits throws exception if profile param is not instance of Profile");
            it("commits 'ADD_ARRAY_OBJECT' with Profile object in value field");
            it("commits 'ADD_ARRAY_OBJECT' with field 'profile_options'");
            it("commits 'ADD_ARRAY_OBJECT' as root mutation");
        });

        describe("setSelectedProfile", function () {
            it("commits throws exception if profile param is not instance of Profile");
            it("commits 'SET_SELECTED_PROFILE' with Profile object");
        });

        describe("changeField", function () {
            it("commits throws exception if option object does not have both field and value properties");
            it("commits 'CHANGE_TYPE' option object");
        });
    });

    describe("getters", function () {
        describe("profiles", function () {
            it("returns empty array if rootState.config is not an instance of Config");
            it("calls 'configInput' root getter with 'profile_options'");
            it("returns profiles.value from 'configInput' root getter if it exists");
            it("returns empty array if profiles.value from 'configInput' root getter does not exist");
        });
    });
});
