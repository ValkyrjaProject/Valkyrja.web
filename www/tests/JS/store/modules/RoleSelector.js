import sinon from "sinon";
import {expect} from "chai";
import roleSelector from "store/modules/RoleSelector";
import {BlankPublicGroup} from "../../../../resources/assets/js/models/BlankPublicGroup";
import PublicGroup from "../../../../resources/assets/js/models/PublicGroup";
import {PublicRole} from "../../../../resources/assets/js/models/PublicRole";
import {Guild} from "../../../../resources/assets/js/models/Guild";
import ignoredChannels from "../../../../resources/assets/js/store/modules/IgnoredChannels";
import {Config} from "../../../../resources/assets/js/models/Config";

describe("RoleSelector", function () {
    const allTypes = {
        NotAdded: 0,
        Public: 1,
        Member: 2,
        SubModerator: 3,
        Moderator: 4,
        Admin: 5
    };
    describe("state", function () {
        let types;
        before(function () {
            types = {...allTypes};
            delete types.NotAdded;
        });
        it("should have 'selectedType' default to Public", function () {
            expect(roleSelector.state.selectedType).to.equal(types.Public);
        });

        it("should have 'types' default to types object", function () {
            expect(roleSelector.state.types).to.eql(types);
        });

        it("should have 'selectedPublicGroup' default to BlankPublicGroup singleton", function () {
            expect(roleSelector.state.selectedPublicGroup).to.equal(BlankPublicGroup.singleton());
        });

        it("should have 'publicGroups' be a list containing only BlankPublicGroup singleton", function () {
            expect(roleSelector.state.publicGroups).to.eql([BlankPublicGroup.singleton()]);
            expect(roleSelector.state.publicGroups[0]).to.equal(BlankPublicGroup.singleton());
        });
    });

    describe("mutations", function () {
        let state;
        beforeEach(function () {
            let storeTypes = {...allTypes};
            delete storeTypes.NotAdded;
            state = {
                types: storeTypes,
                selectedType: null,
                selectedPublicGroup: null,
                publicGroups: [],
            };
        });
        describe("CHANGE_TYPE", function () {
            it("should set 'selectedType' in state if selectedType parameter exists in types array", function () {
                roleSelector.mutations.CHANGE_TYPE(state, allTypes.Moderator);
                expect(state.selectedType).to.equal(allTypes.Moderator);
                roleSelector.mutations.CHANGE_TYPE(state, 2);
                expect(state.selectedType).to.equal(allTypes.Member);
            });

            it("should not set 'selectedType' in state if selectedType parameter does not exist in types array", function () {
                roleSelector.mutations.CHANGE_TYPE(state, 10);
                expect(state.selectedType).to.be.null;
            });

            it("should not allow setting 'selectedType' to NoGroup", function () {
                roleSelector.mutations.CHANGE_TYPE(state, 0);
                expect(state.selectedType).to.be.null;
                roleSelector.mutations.CHANGE_TYPE(state, allTypes.NotAdded);
                expect(state.selectedType).to.be.null;
            });
        });

        describe("ADD_GROUP", function () {
            it("should push group parameter to publicGroups", function () {
                let group = {name: "group"};
                roleSelector.mutations.ADD_GROUP(state, group);
                expect(state.publicGroups).to.contain(group);
            });
        });

        describe("CHANGE_ACTIVE_GROUP", function () {
            it("should set parameter as active group", function () {
                let group = {name: "group"};
                roleSelector.mutations.CHANGE_ACTIVE_GROUP(state, group);
                expect(state.selectedPublicGroup).to.equal(group);
            });
        });

        describe("CHANGE_ROLE_PERMISSION", function () {
            it("should set parameter's role field's permission_level to parameter's permission_level", function () {
                let payload = {
                    role: {
                        permission_level: 5,
                    },
                    permission_level: 2,
                };
                roleSelector.mutations.CHANGE_ROLE_PERMISSION(state, payload);
                expect(payload.role.permission_level).to.equal(payload.permission_level);
            });
        });

        describe("CHANGE_PUBLIC_ID", function () {
            it("should set parameter's role field's public_id to parameter's public_id", function () {
                let payload = {
                    role: {
                        public_id: "5",
                    },
                    public_id: "2",
                };
                roleSelector.mutations.CHANGE_PUBLIC_ID(state, payload);
                expect(payload.role.public_id).to.equal(payload.public_id);
            });
        });

        describe("CHANGE_GROUP_NAME", function () {
            it("should change the selected group's name", function () {
                state.selectedPublicGroup = {name: "name"};
                let newName = "newName";
                roleSelector.mutations.CHANGE_GROUP_NAME(state, newName);
                expect(state.selectedPublicGroup.name).to.equal(newName);
            });
        });

        describe("CHANGE_ROLE_LIMIT", function () {
            it("should change the selected group's role_limit", function () {
                state.selectedPublicGroup = {role_limit: 5};
                let newLimit = 8;
                roleSelector.mutations.CHANGE_ROLE_LIMIT(state, newLimit);
                expect(state.selectedPublicGroup.role_limit).to.equal(newLimit);
            });
        });
    });

    describe("actions", function () {
        let commitStub = sinon.stub();
        let data;
        let state;

        beforeEach(function () {
            let storeTypes = {...allTypes};
            delete storeTypes.NotAdded;
            state = {
                types: storeTypes,
                selectedType: null,
                selectedPublicGroup: {id: ""},
                publicGroups: [],
            };

            commitStub.reset();

            data = {
                state,
                commit: commitStub,
            };
        });

        describe("changeSelectedType", function () {
            it("should only commit if parameter is above 0", function () {
                roleSelector.actions.changeSelectedType(data, 0);
                expect(commitStub.calledOnce).to.be.false;

                roleSelector.actions.changeSelectedType(data, -5);
                expect(commitStub.calledOnce).to.be.false;
            });

            it("should commit 'CHANGE_TYPE' with parameter if it is above 0", function () {
                let type = 10;
                roleSelector.actions.changeSelectedType(data, type);
                expect(commitStub.args[0][0]).to.equal("CHANGE_TYPE");
                expect(commitStub.args[0][1]).to.equal(type);
            });
        });

        describe("addPublicGroup", function () {
            it("throws TypeError if group parameter is not a PublicGroup", function () {
                expect(() => roleSelector.actions.addPublicGroup(data, {})).to.throw(TypeError, "Object is not of type PublicGroup");
                expect(() => roleSelector.actions.addPublicGroup(data, new PublicGroup)).to.not.throw();
            });

            it("should commit 'ADD_ARRAY_OBJECT' with id 'role_groups' and value as group parameter", function () {
                let group = new PublicGroup;
                roleSelector.actions.addPublicGroup(data, group);
                expect(commitStub.calledWith("ADD_ARRAY_OBJECT", {id: "role_groups", value: group})).to.be.true;
            });

            it("should commit 'ADD_ARRAY_OBJECT' as root", function () {
                let group = new PublicGroup;
                roleSelector.actions.addPublicGroup(data, group);
                let response = commitStub.withArgs("ADD_ARRAY_OBJECT");
                expect(response.calledOnce);
                expect(response.args[0][2]).to.eql({root: true});
            });
        });

        describe("selectedPublicGroup", function () {
            it("should commit 'CHANGE_ACTIVE_GROUP' with group parameter", function () {
                let group = {name: "name"};
                roleSelector.actions.selectedPublicGroup(data, group);
                expect(commitStub.withArgs("CHANGE_ACTIVE_GROUP", group).calledOnce).to.be.true;
            });
        });

        describe("addRole", function () {
            it("throws TypeError if role parameter is not of type PublicRole", function () {
                state.selectedPublicGroup = {id: ""};
                expect(() => roleSelector.actions.addRole(data, {})).to.throw(TypeError, "Object is not of type PublicRole, it is of type Object");
                expect(() => roleSelector.actions.addRole(data, new PublicRole)).to.not.throw();
            });

            it("should commit 'CHANGE_ROLE_PERMISSION' with 'role' and 'permission_level' of state.selectedType", function () {
                let role = new PublicRole;
                roleSelector.actions.addRole(data, role);
                expect(commitStub.calledWith("CHANGE_ROLE_PERMISSION", {
                    role,
                    permission_level: state.selectedType,
                })).to.be.true;
            });

            it("should commit 'CHANGE_PUBLIC_ID' with 'role' and 'public_id' of state.selectedPublicGroup.id", function () {
                let role = new PublicRole;
                roleSelector.actions.addRole(data, role);
                expect(commitStub.calledWith("CHANGE_PUBLIC_ID", {
                    role,
                    public_id: state.selectedPublicGroup.id,
                })).to.be.true;
            });

            it("should commit 'CHANGE_ROLE_PERMISSION' before 'CHANGE_PUBLIC_ID'", function () {
                roleSelector.actions.addRole(data, new PublicRole);
                expect(commitStub.getCall(0).calledWith("CHANGE_ROLE_PERMISSION"));
                expect(commitStub.getCall(1).calledWith("CHANGE_PUBLIC_ID"));
            });
        });

        describe("removeRole", function () {
            it("throws TypeError if role parameter is not of type PublicRole", function () {
                expect(() => roleSelector.actions.removeRole(data, {})).to.throw(TypeError, "Object is not of type PublicRole, it is of type Object");
                expect(() => roleSelector.actions.removeRole(data, new PublicRole)).to.not.throw();
            });

            it("should commit 'CHANGE_ROLE_PERMISSION' with 'role' and 'permission_level' being of type NotAdded", function () {
                let role = new PublicRole;
                roleSelector.actions.removeRole(data, role);
                expect(commitStub.calledWith("CHANGE_ROLE_PERMISSION", {
                    role,
                    permission_level: allTypes.NotAdded,
                })).to.be.true;
            });
        });

        describe("changeGroupName", function () {
            it("should return undefined if state.selectedPublicGroup is not of type PublicGroup", function () {
                state.selectedPublicGroup = null;
                expect(roleSelector.actions.changeGroupName(data, "name")).to.be.undefined;
            });

            it("should commit 'CHANGE_GROUP_NAME' with name parameter", function () {
                state.selectedPublicGroup = new PublicGroup;
                let name = "name";
                roleSelector.actions.changeGroupName(data, name);
                expect(commitStub.calledWith("CHANGE_GROUP_NAME", name)).to.be.true;
            });
        });

        describe("changeRoleLimit", function () {
            it("should not commit if state.selectedPublicGroup is not of type PublicGroup", function () {
                state.selectedPublicGroup = null;
                expect(commitStub.called).to.be.false;
            });

            it("should commit 'CHANGE_ROLE_LIMIT' with limit parameter as integer", function () {
                state.selectedPublicGroup = new PublicGroup;
                let limit = 5;
                roleSelector.actions.changeRoleLimit(data, limit);
                expect(commitStub.calledWith("CHANGE_ROLE_LIMIT", limit)).to.be.true;
                commitStub.reset();

                limit = "5";
                roleSelector.actions.changeRoleLimit(data, limit);
                expect(commitStub.calledWith("CHANGE_ROLE_LIMIT", parseInt(limit))).to.be.true;
            });
        });
    });

    describe("getters", function () {
        let commitStub = sinon.stub();
        let data;
        let state;

        beforeEach(function () {
            let storeTypes = {...allTypes};
            delete storeTypes.NotAdded;
            state = {
                types: storeTypes,
                selectedType: null,
                selectedPublicGroup: {id: ""},
                publicGroups: [],
            };

            commitStub.reset();

            data = {
                state,
                commit: commitStub,
            };
        });

        describe("availableRoles", function () {
            it("returns empty array if rootState.config is not an instance of Config", function () {
                let rootState = {
                    config: null,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                expect(roleSelector.getters.availableRoles(data, {}, rootState, {})).to.deep.equal([]);
            });

            it("returns empty array if rootState.guild is not an instance of Guild", function () {
                let rootState = {
                    config: new Config,
                    guild: null,
                };
                expect(roleSelector.getters.availableRoles(data, {}, rootState, {})).to.deep.equal([]);
            });

            it("calls 'configInput' root getter with 'roles'", function () {
                let rootState = {
                    config: new Config,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                rootGetters.configInput.returns({value:[]});

                expect(rootGetters.configInput.calledOnce, "configInput is not called before test").to.be.false;
                roleSelector.getters.availableRoles(state, {}, rootState, rootGetters);
                expect(rootGetters.configInput.calledWith("roles"), "configInput was called").to.be.true;
            });

            it("should return list of configInput arrays that match guild roles with permission level below 1", function () {
                let guildRoles = [];
                for (let i = 0; i < 50; i++) {
                    guildRoles.push({id: i.toString()});
                }

                let configInputRoles = [];
                for (let i = 10; i < 30; i++) {
                    configInputRoles.push({
                        id: i.toString(),
                        permission_level: Math.floor(Math.random()*(7)-3),
                    });
                }

                let rootState = {
                    config: new Config,
                    guild: new Guild(guildRoles, [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                let value = {value: configInputRoles};
                rootGetters.configInput.returns(value);
                let response = roleSelector.getters.availableRoles(state, {}, rootState, rootGetters);
                expect(response, "should only have negative permission_level roles").to.have.members(configInputRoles.filter(r => r.permission_level < 1));
                expect(response, "should not have positive permission_level roles").to.not.have.members(configInputRoles.filter(r => r.permission_level > 0));
            });
        });

        describe("addedRoles", function () {

            it("returns empty array if rootState.config is not an instance of Config", function () {
                let rootState = {
                    config: null,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                expect(roleSelector.getters.addedRoles(data, {}, rootState, {})).to.deep.equal([]);
            });

            it("returns empty array if rootState.guild is not an instance of Guild", function () {
                let rootState = {
                    config: new Config,
                    guild: null,
                };
                expect(roleSelector.getters.addedRoles(data, {}, rootState, {})).to.deep.equal([]);
            });

            it("calls 'configInput' root getter with 'roles'", function () {
                let rootState = {
                    config: new Config,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                rootGetters.configInput.returns({value:[]});

                expect(rootGetters.configInput.calledOnce, "configInput is not called before test").to.be.false;
                roleSelector.getters.addedRoles(state, {}, rootState, rootGetters);
                expect(rootGetters.configInput.calledWith("roles"), "configInput was called").to.be.true;
            });

            it("should return list of configInput arrays that match guild roles with non-Public type regardless of selectedPublicGroup", function () {
                state.selectedType = allTypes.Member;
                state.selectedPublicGroup = {id: 5};
                let guildRoles = [];
                for (let i = 0; i < 50; i++) {
                    guildRoles.push({id: i.toString()});
                }

                let configInputRoles = [];
                for (let i = 10; i < 30; i++) {
                    configInputRoles.push({
                        id: i.toString(),
                        permission_level: Math.floor(Math.random()*(allTypes.length)),
                        public_id: Math.floor(Math.random()*(7)),
                    });
                }

                let rootState = {
                    config: new Config,
                    guild: new Guild(guildRoles, [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                let value = {value: configInputRoles};
                rootGetters.configInput.returns(value);
                let response = roleSelector.getters.addedRoles(state, {}, rootState, rootGetters);
                expect(response, "should only have roles with selected permission level regardless of public group").to.have.members(configInputRoles.filter(r => r.permission_level === state.selectedType));
                expect(response, "should not include roles roles outside selected permission level regardless of public group").to.not.have.members(configInputRoles.filter(r => r.permission_level !== state.selectedType));
            });

            it("should return list of configInput arrays that match guild roles with Public and selected PublicGroup", function () {
                state.selectedType = allTypes.Public;
                state.selectedPublicGroup = {id: 5};
                let guildRoles = [];
                for (let i = 0; i < 50; i++) {
                    guildRoles.push({id: i.toString()});
                }

                let configInputRoles = [];
                for (let i = 10; i < 30; i++) {
                    configInputRoles.push({
                        id: i.toString(),
                        permission_level: Math.floor(Math.random()*(allTypes.length)),
                        public_id: Math.floor(Math.random()*(7)),
                    });
                }

                let rootState = {
                    config: new Config,
                    guild: new Guild(guildRoles, [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                let value = {value: configInputRoles};
                rootGetters.configInput.returns(value);
                let response = roleSelector.getters.addedRoles(state, {}, rootState, rootGetters);
                expect(response, "should only have roles with selected permission level and public group").to.have.members(configInputRoles.filter(r => {
                    return r.permission_level === state.selectedType && r.public_id === state.selectedPublicGroup
                }));
                expect(response, "should not include roles roles outside selected permission level and public group").to.not.have.members(configInputRoles.filter(r => {
                    return r.permission_level !== state.selectedType && r.public_id !== state.selectedPublicGroup
                }));
            });
        });
    });
});
