import sinon from "sinon";
import {expect} from "chai";
import reactionRoles from "store/modules/ReactionRoles";
import ReactionRole from "../../../../resources/assets/js/models/ReactionRole";
import {GuildRole} from "../../../../resources/assets/js/models/GuildRole";
import {Guild} from "../../../../resources/assets/js/models/Guild";
import {Config} from "../../../../resources/assets/js/models/Config";

describe("ReactionRoles Vuex module", function () {

    let state;
    beforeEach(function () {
        state = {
            selectedRole: ReactionRole.newInstance("id", [])
        };
    });

    describe("state", function () {
        it("should have selectedRole set to null", function () {
            expect(reactionRoles.state.selectedRole).to.be.null;
        });
    });

    describe("mutations", function () {
        describe("SET_SELECTED_ROLE", function () {
            it("should sets selectedRole to parameter if it is a ReactionRole", function () {
                let role = new ReactionRole;
                reactionRoles.mutations.SET_SELECTED_ROLE(state, role);
                expect(state.selectedRole).to.equal(role);
            });

            it("should sets selectedRole to parameter if it is an object", function () {
                let role = {};
                reactionRoles.mutations.SET_SELECTED_ROLE(state, role);
                expect(state.selectedRole).to.equal(role);
            });

            it("should sets selectedRole to parameter if it is null", function () {
                reactionRoles.mutations.SET_SELECTED_ROLE(state, null);
                expect(state.selectedRole).to.be.null;
            });
        });

        describe("CHANGE_TYPE", function () {
            it("should set field of selectedRole if option parameter has field and value", function () {
                let option = {
                    field: "messageId",
                    value: "new value"
                };
                reactionRoles.mutations.CHANGE_TYPE(state, option);
                expect(state.selectedRole[option.field]).to.equal(option.value);
            });

            it("should not change field of selectedRole if selectedRole is not an instance of ReactionRole", function () {
                state.selectedRole = {
                    messageId: "value"
                };
                let option = {
                    field: "messageId",
                    value: "new value"
                };
                reactionRoles.mutations.CHANGE_TYPE(state, option);
                expect(state.selectedRole[option.field]).to.not.equal(option.value);
            });

            it("should not change field of selectedRole if selectedRole is null", function () {
                state.selectedRole = null;
                let option = {
                    field: "messageId",
                    value: "new value"
                };
                reactionRoles.mutations.CHANGE_TYPE(state, option);
                expect(state.selectedRole).to.be.null;
            });

            it("should not change field of selectedRole if 'field' field from parameter does not exist", function () {
                let option = {
                    value: "new value"
                };
                let role = {...state.selectedRole};
                reactionRoles.mutations.CHANGE_TYPE(state, option);
                expect(state.selectedRole).to.eql(role);
            });

            it("should not change field of selectedRole if 'value' field from parameter does not exist", function () {
                let option = {
                    field: "messageId"
                };
                let valueBeforeMutation = state.selectedRole[option.field];
                reactionRoles.mutations.CHANGE_TYPE(state, option);
                expect(state.selectedRole[option.field]).to.equal(valueBeforeMutation);
            });
        });

        describe("DELETE_ROLE_FROM_INDEX", function () {
            let obj;
            beforeEach(function () {
                obj = {
                    array: [1, 2, 3, 4],
                    index: 1
                };
            });

            it("should remove object from array field from parameter's index field", function () {
                reactionRoles.mutations.DELETE_ROLE_FROM_INDEX(state, obj);
                expect(obj.array).to.eql([1,3,4]);
            });
        });

        describe("ADD_ROLE", function () {
            it("should add GuildRole parameter to selectedRole's roles array field", function () {
                let newRole = new GuildRole("id", "name");
                reactionRoles.mutations.ADD_ROLE(state, newRole);
                expect(state.selectedRole.roles).to.eql([newRole]);
            });
        });

        describe("DELETE_ROLE", function () {
            it("should delete role from selectedRole's roles array field if it exists", function () {
                let newRole = new GuildRole("id", "name");
                state.selectedRole.roles = [newRole];
                reactionRoles.mutations.DELETE_ROLE(state, newRole);
                expect(state.selectedRole.roles).to.not.contain(newRole);
            });
        });
    });

    describe("actions", function () {
        let commitStub = sinon.stub();
        let data;

        beforeEach(function () {
            commitStub.reset();

            data = {
                state,
                commit: commitStub,
            };
        });

        describe("addRole", function () {
            it("should throw TypeError if role parameter is not a GuildRole instance", function () {
                expect(() => reactionRoles.actions.addRole(data, {})).to.throw(TypeError, "Object is not of type GuildRole, it is of type Object");
                expect(() => reactionRoles.actions.addRole(data, null)).to.throw(TypeError, "Object is not of type GuildRole, it is of type null");
            });

            it("should commit ADD_ROLE if role parameter is a GuildRole instance", function () {
                let role = new GuildRole("id", "name");
                reactionRoles.actions.addRole(data, role);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.getCall(0).args[0]).to.equal("ADD_ROLE");
                expect(commitStub.getCall(0).args[1]).to.equal(role);
            });
        });

        describe("removeRole", function () {
            it("should throw TypeError if role parameter is not a GuildRole instance", function () {
                expect(() => reactionRoles.actions.removeRole(data, {})).to.throw(TypeError, "Object is not of type GuildRole, it is of type Object");
                expect(() => reactionRoles.actions.removeRole(data, null)).to.throw(TypeError, "Object is not of type GuildRole, it is of type null");
            });

            it("should commit DELETE_ROLE if role parameter is a GuildRole instance", function () {
                let role = new GuildRole("id", "name");
                reactionRoles.actions.removeRole(data, role);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.getCall(0).args[0]).to.equal("DELETE_ROLE");
                expect(commitStub.getCall(0).args[1]).to.equal(role);
            });
        });

        describe("addReactionRole", function () {
            it("should throw TypeError if role parameter is not a ReactionRole instance", function () {
                expect(() => reactionRoles.actions.addReactionRole(data, {})).to.throw(TypeError, "Object is not of type ReactionRole, it is of type Object");
                expect(() => reactionRoles.actions.addReactionRole(data, null)).to.throw(TypeError, "Object is not of type ReactionRole, it is of type null");
            });

            it("should commit ADD_ARRAY_OBJECT if role parameter is a GuildRole instance", function () {
                let role = new ReactionRole;
                reactionRoles.actions.addReactionRole(data, role);
                expect(commitStub.calledTwice).to.be.true;
                expect(commitStub.getCall(0).args[0]).to.equal("ADD_ARRAY_OBJECT");
                expect(commitStub.getCall(0).args[1]).to.eql({
                    id: "reaction_roles",
                    value: role,
                });
                expect(commitStub.getCall(0).args[2]).to.eql({root: true});
            });

            it("should commit SET_SELECTED_ROLE if role parameter is a GuildRole instance", function () {
                let role = new ReactionRole;
                reactionRoles.actions.addReactionRole(data, role);
                expect(commitStub.calledTwice).to.be.true;
                expect(commitStub.getCall(1).args[0]).to.equal("SET_SELECTED_ROLE");
                expect(commitStub.getCall(1).args[1]).to.equal(role);
            });
        });

        describe("removeReactionRole", function () {
            let rootStub = sinon.stub();
            let stateRoles = {
                value: [
                    new ReactionRole,
                    new ReactionRole,
                    new ReactionRole,
                    new ReactionRole,
                    new ReactionRole
                ]
            };
            beforeEach(function () {
                rootStub.resetHistory();
                rootStub.returns(stateRoles);

                data = {
                    state,
                    commit: commitStub,
                    rootState: {
                        config: {
                            find: rootStub
                        }
                    }
                };
            });
            it("should throw TypeError if role parameter is not a ReactionRole instance", function () {
                expect(() => reactionRoles.actions.removeReactionRole(data, {})).to.throw(TypeError, "Object is not of type ReactionRole, it is of type Object");
                expect(() => reactionRoles.actions.removeReactionRole(data, null)).to.throw(TypeError, "Object is not of type ReactionRole, it is of type null");
            });

            it("should commit DELETE_ROLE_FROM_INDEX if role parameter is a GuildRole instance and exists in reactionRoles Config value", function () {
                let index = 3;
                reactionRoles.actions.removeReactionRole(data, stateRoles.value[index]);
                expect(commitStub.getCall(0).args[0]).to.equal("DELETE_ROLE_FROM_INDEX");
                expect(commitStub.getCall(0).args[1]).to.eql({
                    array: stateRoles.value,
                    index: index
                });
            });

            it("should not commit SET_SELECTED_ROLE if deleted role is not the selected one", function () {
                let index = 3;
                state.selectedRole = stateRoles.value[2];

                reactionRoles.actions.removeReactionRole(data, stateRoles.value[index]);

                expect(commitStub.getCall(0).args[0]).to.equal("DELETE_ROLE_FROM_INDEX");
                expect(commitStub.getCall(1)).to.be.null;
            });

            it("should commit SET_SELECTED_ROLE with first role if deleted role is the selected one", function () {
                let index = 1;
                state.selectedRole = stateRoles.value[index];

                reactionRoles.actions.removeReactionRole(data, stateRoles.value[index]);
                expect(stateRoles.value[index]).to.equal(state.selectedRole);
                expect(commitStub.getCall(0).args[0]).to.equal("DELETE_ROLE_FROM_INDEX");
                expect(commitStub.getCall(1).args[0]).to.equal("SET_SELECTED_ROLE");
                expect(commitStub.getCall(1).args[1]).to.equal(stateRoles.value[0]);
            });
        });

        describe("setActiveRole", function () {
            it("should throw TypeError if role parameter is not a ReactionRole instance", function () {
                expect(() => reactionRoles.actions.setActiveRole(data, {})).to.throw(TypeError, "Object is not of type ReactionRole, it is of type Object");
                expect(() => reactionRoles.actions.setActiveRole(data, null)).to.throw(TypeError, "Object is not of type ReactionRole, it is of type null");
            });

            it("should commit SET_SELECTED_ROLE if role parameter is a ReactionRole instance", function () {
                let role = new ReactionRole;
                reactionRoles.actions.setActiveRole(data, role);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.getCall(0).args[0]).to.equal("SET_SELECTED_ROLE");
                expect(commitStub.getCall(0).args[1]).to.equal(role);
            });
        });

        describe("changeField", function () {
            it("should throw TypeError if 'field' or 'value' fields of parameter does not exist", function () {
                expect(() => reactionRoles.actions.changeField(data, {
                    field: "exists"
                })).to.throw(TypeError, "Object does not have 'field' and 'value' fields");
                expect(() => reactionRoles.actions.changeField(data, {
                    value: "exists"
                })).to.throw(TypeError, "Object does not have 'field' and 'value' fields");
            });

            it("should commit CHANGE_TYPE if role parameter has 'field' and 'value' fields", function () {
                let option = {
                    field: "field",
                    value: "value"
                };
                reactionRoles.actions.changeField(data, option);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.getCall(0).args[0]).to.equal("CHANGE_TYPE");
                expect(commitStub.getCall(0).args[1]).to.equal(option);
            });
        });
    });

    describe("getters", function () {
        let configStub = sinon.stub();
        let data;
        beforeEach(function () {
            configStub.resetHistory();
            data = {
                state,
                rootState: {
                    config: new Config,
                    guild: new Guild([
                        new GuildRole("1", "name"),
                        new GuildRole("2", "name"),
                        new GuildRole("3", "name"),
                        new GuildRole("4", "name")
                    ], [], {
                        id: "id",
                        name: "name",
                        icon: "icon",
                    })
                },
                rootGetters: {
                    configInput: configStub
                }
            };
        });
        describe("roles", function () {
            it("should return empty array if rootState.config is not a Config instance", function () {
                data.rootState.config = {};
                expect(reactionRoles.getters.roles(data.state, data.rootState, data.rootGetters)).to.be.an("array").that.is.empty;
            });

            it("should return empty array if rootState.guild is not a Guild instance", function () {
                data.rootState.guild = {};
                expect(reactionRoles.getters.roles(data.state, data.rootState, data.rootGetters)).to.be.an("array").that.is.empty;
            });

            it("should return empty array if reactionRoles from rootGetters.configInput is null", function () {
                configStub.returns(null);
                expect(reactionRoles.getters.roles(data.state, data.rootState, data.rootGetters)).to.be.an("array").that.is.empty;
            });

            it("should return empty array if reactionRoles.value from rootGetters.configInput is null", function () {
                configStub.returns({value: null});
                expect(reactionRoles.getters.roles(data.state, data.rootState, data.rootGetters)).to.be.an("array").that.is.empty;
            });

            it("should return reactionRoles.value from rootGetters.configInput if it exists", function () {
                configStub.returns({value: "value"});
                expect(reactionRoles.getters.roles(data.state, data.rootState, data.rootGetters)).to.equal("value");
            });
        });

        describe("availableRoles", function () {
            it("should return empty array if rootState.config is not a Config instance", function () {
                data.rootState.config = {};
                expect(reactionRoles.getters.availableRoles(data.state, data.rootState)).to.be.an("array").that.is.empty;
            });

            it("should return empty array if rootState.guild is not a Guild instance", function () {
                data.rootState.guild = {};
                expect(reactionRoles.getters.availableRoles(data.state, data.rootState)).to.be.an("array").that.is.empty;
            });

            it("should return GuildRoles which id's do not exist in selectedRole's role field", function () {
                let roles = [...data.rootState.guild.roles];
                roles.splice(1, 1);
                data.state.selectedRole.roles = roles;
                let response = reactionRoles.getters.availableRoles(data.state, data.rootState);
                expect(response).to.have.members([data.rootState.guild.roles[1]]);
                expect(response).to.not.have.members(roles);
            });
        });

        describe("addedRoles", function () {
            it("should return empty array if rootState.config is not a Config instance", function () {
                data.rootState.config = {};
                expect(reactionRoles.getters.addedRoles(data.state, data.rootState)).to.be.an("array").that.is.empty;
            });

            it("should return empty array if rootState.guild is not a Guild instance", function () {
                data.rootState.guild = {};
                expect(reactionRoles.getters.addedRoles(data.state, data.rootState)).to.be.an("array").that.is.empty;
            });

            it("should return GuildRoles which id's exist in selectedRole's role field", function () {
                let roles = [...data.rootState.guild.roles];
                roles.splice(1, 1);
                data.state.selectedRole.roles = roles;
                let response = reactionRoles.getters.addedRoles(data.state, data.rootState);
                expect(response).to.have.members(roles);
                expect(response).to.not.have.members([data.rootState.guild.roles[1]]);
            });
        });
    });
});
