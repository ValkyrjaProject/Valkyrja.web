import sinon from "sinon";
import {expect} from "chai";
import profileEditor from "store/modules/ProfileEditor";
import loglevel from "loglevel";
import {Profile} from "models/Profile";

describe("ProfileEditor Vuex module", function () {
    global.log = sinon.stub(loglevel);
    describe("state", function () {
        it("should set selectedProfile as 'null'", function () {
            expect(profileEditor.state.selectedProfile).to.be.null;
        });
    });

    describe("actions", function () {
        let state;
        beforeEach(function () {
            state = {
                selectedProfile: null
            };
        });

        describe("addProfile", function () {
            it("throws exception if profile param is not instance of Profile", function () {
                expect(() => profileEditor.actions.addProfile(state, {})).to.throw(TypeError, "Object is not of type Profile");
            });
            it("commits 'ADD_ARRAY_OBJECT' with Profile object in value field", function () {
                let profile = new Profile;
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub
                };
                profileEditor.actions.addProfile(data, profile);
                expect(commitStub.calledOnce).to.be.true;
            });
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
