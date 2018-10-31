import sinon from "sinon";
import {expect} from "chai";
import profileEditor from "store/modules/ProfileEditor";
import loglevel from "loglevel";
import {Profile} from "models/Profile";
import {Guild} from "../../../../resources/assets/js/models/Guild";
import {Config} from "../../../../resources/assets/js/models/Config";

describe("ProfileEditor Vuex module", function () {

    let state;
    beforeEach(function () {
        state = {
            selectedProfile: null
        };
    });

    describe("state", function () {
        it("should set selectedProfile as 'null'", function () {
            expect(profileEditor.state.selectedProfile).to.be.null;
        });
    });

    describe("mutations", function () {
        describe("SET_SELECTED_PROFILE", function () {
            it("should set selectedProfile from parameter", function () {
                let value = "value";
                expect(state.selectedProfile).to.be.null;
                profileEditor.mutations.SET_SELECTED_PROFILE(state, value);
                expect(state.selectedProfile).to.equal(value);
            });
        });

        describe("CHANGE_TYPE", function () {
            it("should not set selectedProfile if it is null", function () {
                let option = "value";
                expect(state.selectedProfile).to.be.null;
                profileEditor.mutations.CHANGE_TYPE(state, option);
                expect(state.selectedProfile).to.be.null;
            });

            it("should not set selectedProfile if value field does not have option.field", function () {
                let value = {value: {field1: "test"}};
                state.selectedProfile = value;
                profileEditor.mutations.CHANGE_TYPE(state, {field: "value"});
                expect(state.selectedProfile).to.deep.equal(value);
            });

            it("should set selectedProfile if value field does has option.field", function () {
                state.selectedProfile = {value: {field1: "test"}};
                profileEditor.mutations.CHANGE_TYPE(state, {field: "field1", value: "new value"});
                expect(state.selectedProfile).to.deep.equal({value: {field1: "new value"}});
            });
        });
    });

    describe("actions", function () {
        describe("addProfile", function () {
            it("throws exception if profile param is not instance of Profile", function () {
                expect(() => profileEditor.actions.addProfile(state, {})).to.throw(TypeError, "Object is not of type Profile");
            });

            it("commits 'ADD_ARRAY_OBJECT' with Profile object in value field", function () {
                let profile = new Profile;
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                expect(commitStub.calledOnce).to.be.false;
                profileEditor.actions.addProfile(data, profile);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.args[0][0]).to.equal("ADD_ARRAY_OBJECT");
                expect(commitStub.args[0][1]).to.deep.equal({id: "profile_options", value: profile});
            });

            it("commits 'ADD_ARRAY_OBJECT' as root mutation", function () {
                let profile = new Profile;
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                profileEditor.actions.addProfile(data, profile);
                expect(commitStub.args[0][0]).to.equal("ADD_ARRAY_OBJECT");
                expect(commitStub.args[0][2]).to.deep.equal({root: true});
            });
        });

        describe("setSelectedProfile", function () {
            it("commits throws exception if profile param is not instance of Profile", function () {
                expect(() => profileEditor.actions.setSelectedProfile(state, {})).to.throw(TypeError, "Object is not of type Profile");
            });

            it("commits 'SET_SELECTED_PROFILE' with Profile object", function () {
                let profile = new Profile;
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                expect(commitStub.calledOnce).to.be.false;
                profileEditor.actions.setSelectedProfile(data, profile);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.args[0][0]).to.equal("SET_SELECTED_PROFILE");
                expect(commitStub.args[0][1]).to.equal(profile);
            });
        });

        describe("changeField", function () {
            it("commits throws exception if option object does not have both field and value properties", function () {
                let errorMessage = "Object does not have 'field' and 'value' fields";
                expect(() => profileEditor.actions.changeField(state, {field: "field"})).to.throw(TypeError, errorMessage);
                expect(() => profileEditor.actions.changeField(state, {value: "value"})).to.throw(TypeError, errorMessage);
                expect(() => profileEditor.actions.changeField({state, commit: () =>{}}, {field: "field", value: "value"})).to.not.throw();
            });

            it("commits 'CHANGE_TYPE' option object", function () {
                let option = {field: "field", value: "value"};
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                expect(commitStub.calledOnce).to.be.false;
                profileEditor.actions.changeField(data, option);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.args[0][0]).to.equal("CHANGE_TYPE");
                expect(commitStub.args[0][1]).to.equal(option);
            });
        });
    });

    describe("getters", function () {
        describe("profiles", function () {
            it("returns empty array if rootState.config is not an instance of Config", function () {
                let rootState = {
                    config: null,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                expect(profileEditor.getters.profiles(state, {}, rootState, {})).to.deep.equal([]);
            });

            it("returns empty array if rootState.guild is not an instance of Guild", function () {
                let rootState = {
                    config: new Config,
                    guild: null,
                };
                expect(profileEditor.getters.profiles(state, {}, rootState, {})).to.deep.equal([]);
            });

            it("calls 'configInput' root getter with 'profile_options'", function () {
                let rootState = {
                    config: new Config,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                rootGetters.configInput.returns({value:null});
                expect(rootGetters.configInput.calledOnce, "configInput is not called before test").to.be.false;
                profileEditor.getters.profiles(state, {}, rootState, rootGetters);
                expect(rootGetters.configInput.calledOnce, "configInput was called").to.be.true;
                expect(rootGetters.configInput.args[0][0]).to.equal("profile_options");
            });

            it("returns profiles.value from 'configInput' root getter if it exists", function () {
                let rootState = {
                    config: new Config,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                let data = {value: "root value"};
                rootGetters.configInput.returns(data);
                expect(profileEditor.getters.profiles(state, {}, rootState, rootGetters)).to.deep.equal(data.value);
            });

            it("returns empty array if profiles.value from 'configInput' root getter does not exist", function () {
                let rootState = {
                    config: new Config,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                rootGetters.configInput.returns({value:null});
                expect(profileEditor.getters.profiles(state, {}, rootState, rootGetters)).to.deep.equal([]);
            });
        });
    });
});
