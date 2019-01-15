import sinon from "sinon";
import {expect} from "chai";
import levelSelector from "store/modules/LevelSelector";
import loglevel from "loglevel";
import {Profile} from "models/Profile";
import {Guild} from "../../../../resources/assets/js/models/Guild";
import {Config} from "../../../../resources/assets/js/models/Config";
import {PublicRole} from "../../../../resources/assets/js/models/PublicRole";
import roleSelector from "../../../../resources/assets/js/store/modules/RoleSelector";
import {GuildRole} from "../../../../resources/assets/js/models/GuildRole";

describe("LevelSelector Vuex module", function () {

    let state;
    beforeEach(function () {
        state = {
            /** @member {Array} levels */
            levels: [],
            /** @member {Number} selectedLevel */
            selectedLevel: null
        };
    });

    describe("state", function () {
        it("should set levels' default value as empty array", function () {
            expect(levelSelector.state.levels).to.be.an("array").that.is.empty;
        });

        it("should set selectedLevel's default value as null", function () {
            expect(levelSelector.state.selectedLevel).to.be.null;
        });
    });

    describe("mutations", function () {
        describe("ADD_LEVEL", function () {
            it("should push level parameter into state.levels", function () {
                let value = 5;
                expect(state.levels).to.be.empty;
                levelSelector.mutations.ADD_LEVEL(state, value);
                expect(state.levels).to.eql([value]);
            });

            it("should parse level parameter into an int", function () {
                let value = "5";
                expect(state.levels).to.be.empty;
                levelSelector.mutations.ADD_LEVEL(state, value);
                expect(state.levels).to.eql([parseInt(value)]);
            });
        });

        describe("CHANGE_SELECTED_LEVEL", function () {
            it("should set level parameter value as state.selectedLevel", function () {
                let value = 5;
                expect(state.selectedLevel).to.be.null;
                levelSelector.mutations.CHANGE_SELECTED_LEVEL(state, value);
                expect(state.selectedLevel).to.eql(value);
            });

            it("should parse level parameter into an int", function () {
                let value = "5";
                expect(state.selectedLevel).to.be.null;
                levelSelector.mutations.CHANGE_SELECTED_LEVEL(state, value);
                expect(state.selectedLevel).to.eql(parseInt(value));
            });
        });

        describe("CHANGE_ROLE_LEVEL", function () {
            it("should set parameter's role.level field to parameter's level field", function () {
                let payload = {
                    role: {
                        level: 1
                    },
                    level: "5"
                };
                levelSelector.mutations.CHANGE_ROLE_LEVEL(state, payload);
                expect(payload.role.level).to.equal(payload.level);
            });
        });
    });

    describe("actions", function () {
        describe("addLevel", function () {
            it("commits ADD_LEVEL with level parameter", function () {
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                let value = 5;
                levelSelector.actions.addLevel(data, value);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.getCall(0).args[0]).to.equal("ADD_LEVEL");
                expect(commitStub.getCall(0).args[1]).to.equal(value);
            });
        });

        describe("changeSelectedLevel", function () {
            it("commits CHANGE_SELECTED_LEVEL with level parameter", function () {
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                let value = 5;
                levelSelector.actions.changeSelectedLevel(data, value);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.getCall(0).args[0]).to.equal("CHANGE_SELECTED_LEVEL");
                expect(commitStub.getCall(0).args[1]).to.equal(value);
            });
        });

        describe("changeRoleLevel", function () {
            it("should throw error if role field is missing from payload parameter", function () {
                let payload = {
                    level: "leve;"
                };
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                expect(() => levelSelector.actions.changeRoleLevel(data, payload)).to.throw(TypeError, "Payload does not have role and level properties");
            });

            it("should throw error if level field is missing from payload parameter", function () {
                let payload = {
                    role: "role"
                };
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                expect(() => levelSelector.actions.changeRoleLevel(data, payload)).to.throw(TypeError, "Payload does not have role and level properties");
            });

            it("should throw error if role and level field is missing from payload parameter", function () {
                let payload = {};
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                expect(() => levelSelector.actions.changeRoleLevel(data, payload)).to.throw(TypeError, "Payload does not have role and level properties");
            });

            it("should throw error if role field from parameter is not an instance of PublicRole", function () {
                let payload = {
                    role: "role",
                    level: "level",
                };
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };

                expect(() => levelSelector.actions.changeRoleLevel(data, payload)).to.throw(TypeError, "Object is not of type PublicRole");

                payload.role = {};
                expect(() => levelSelector.actions.changeRoleLevel(data, payload)).to.throw(TypeError, "Object is not of type PublicRole");
            });

            it("should commit CHANGE_ROLE_LEVEL with role and level fields from parameters if parameter is valid", function () {
                let payload = {
                    role: new PublicRole,
                    level: "level",
                };
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                levelSelector.actions.changeRoleLevel(data, payload);
                expect(commitStub.getCall(0).args[0]).to.equal("CHANGE_ROLE_LEVEL");
                expect(commitStub.getCall(0).args[1]).to.eql(payload);
            });
        });
    });

    describe("getters", function () {
        describe("availableRoles", function () {
            it("returns empty array if rootState.config is not an instance of Config", function () {
                let rootState = {
                    config: null,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                expect(levelSelector.getters.availableRoles(state, {}, rootState, {})).to.deep.equal([]);
            });

            it("returns empty array if rootState.guild is not an instance of Guild", function () {
                let rootState = {
                    config: new Config,
                    guild: null,
                };
                expect(levelSelector.getters.availableRoles(state, {}, rootState, {})).to.deep.equal([]);
            });
            it("should return a list of rootGetters roles if corresponding guild roles has level 0", function () {
                let guildRoles = [];
                for (let i = 0; i < 50; i++) {
                    guildRoles.push(new GuildRole(i.toString(), ""));
                }

                let configInputRoles = [];
                for (let i = 10; i < 30; i++) {
                    configInputRoles.push({
                        id: i.toString(),
                        level: Math.floor(Math.random()*(5)),
                    });
                }
                configInputRoles.push({
                    id: "30",
                    level: 0,
                });
                configInputRoles.push({
                    id: "31",
                    level: 4,
                });

                let rootState = {
                    config: new Config,
                    guild: new Guild(guildRoles, [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                let value = {value: configInputRoles};
                rootGetters.configInput.returns(value);
                let response = levelSelector.getters.availableRoles(state, {}, rootState, rootGetters);
                let roles_with_level_0 = configInputRoles.filter(r => r.level === 0);
                let roles_with_level_above_0 = configInputRoles.filter(r => r.level > 0);
                expect(roles_with_level_0).to.have.length.of.at.least(1);
                expect(roles_with_level_above_0).to.have.length.of.at.least(1);
                expect(response).to.have.length.of.at.least(1);

                expect(response, "should only have roles with level 0").to.have.members(roles_with_level_0);
                expect(response, "should not have roles with level above 0").to.not.have.members(roles_with_level_above_0);
            });
        });

        describe("addedRoles", function () {
            it("returns empty array if rootState.config is not an instance of Config", function () {
                let rootState = {
                    config: null,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                expect(levelSelector.getters.addedRoles(state, {}, rootState, {})).to.deep.equal([]);
            });

            it("returns empty array if rootState.guild is not an instance of Guild", function () {
                let rootState = {
                    config: new Config,
                    guild: null,
                };
                expect(levelSelector.getters.addedRoles(state, {}, rootState, {})).to.deep.equal([]);
            });
            it("should return a list of rootGetters roles if corresponding guild roles has level above 0", function () {
                state.selectedLevel = 3;

                let guildRoles = [];
                for (let i = 0; i < 50; i++) {
                    guildRoles.push(new GuildRole(i.toString(), ""));
                }

                let configInputRoles = [];
                for (let i = 10; i < 30; i++) {
                    configInputRoles.push({
                        id: i.toString(),
                        level: Math.floor(Math.random()*(5)),
                    });
                }
                configInputRoles.push({
                    id: "30",
                    level: state.selectedLevel+1,
                });
                configInputRoles.push({
                    id: "31",
                    level: state.selectedLevel,
                });

                let rootState = {
                    config: new Config,
                    guild: new Guild(guildRoles, [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                let value = {value: configInputRoles};
                rootGetters.configInput.returns(value);
                let response = levelSelector.getters.addedRoles(state, {}, rootState, rootGetters);


                let roles_with_selected_level = configInputRoles.filter(r => r.level === state.selectedLevel);
                let roles_without_selected_level = configInputRoles.filter(r => r.level !== state.selectedLevel);


                expect(roles_with_selected_level).to.have.length.of.at.least(1);
                expect(roles_without_selected_level).to.have.length.of.at.least(1);
                expect(response).to.have.length.of.at.least(1);

                expect(response, `should have roles with level ${state.selectedLevel}`).to.have.members(roles_with_selected_level);
                expect(response, `should not have roles with level ${state.selectedLevel}`).to.not.have.members(roles_without_selected_level);
            });
        });
    });
});

