import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import loglevel from "loglevel";
import {CustomCommand} from "models/CustomCommand";
import customCommands from "../../../../resources/assets/js/store/modules/CustomCommands";
import {ConfigData} from "../../../../resources/assets/js/models/ConfigData";
import {Guild} from "../../../../resources/assets/js/models/Guild";
import {Config} from "../../../../resources/assets/js/models/Config";

describe("CustomCommands Vuex module", function () {
    let state = {
        /** @member {CustomCommand|null} */
        selectedCommand: null
    };
    beforeEach(function () {
        state.selectedCommand = null;
    });

    describe("state", function () {
        describe("selectedCommand", function () {
            it("should default to null", function () {
                expect(customCommands.state.selectedCommand).to.be.null;
            });
        });
    });

    describe("mutations", function () {
        describe("SET_SELECTED_COMMAND", function () {
            it("should set selectedCommand to CustomCommand instance as parameter", function () {
                let command = CustomCommand.newInstance();
                state.selectedCommand = null;

                customCommands.mutations.SET_SELECTED_COMMAND(state, command);
                expect(state.selectedCommand).to.equal(command);
            });

            it("should set selectedCommand to null as paramater", function () {
                let command = CustomCommand.newInstance();
                state.selectedCommand = command;

                customCommands.mutations.SET_SELECTED_COMMAND(state, null);
                expect(state.selectedCommand).to.be.null;
            });

            it("should set selectedCommand to empty object as paramater", function () {
                let object = {foo: "bar"};
                state.selectedCommand = null;

                customCommands.mutations.SET_SELECTED_COMMAND(state, object);
                expect(state.selectedCommand).to.equal(object);
            });
        });

        describe("CHANGE_TYPE", function () {
            it("should change a field of selectedCommand if it is a CustomCommand instance", function () {
                let option = {
                    field: "description",
                    value: "new value"
                };
                state.selectedCommand = CustomCommand.newInstance();

                expect(state.selectedCommand.description).to.not.equal(option.value);
                customCommands.mutations.CHANGE_TYPE(state, option);
                expect(state.selectedCommand.description).to.equal(option.value);
            });

            it("should not change a field of selectedCommand if it is an empty object", function () {
                let option = {
                    field: "description",
                    value: "new value"
                };
                state.selectedCommand = {};

                expect(state.selectedCommand.description).to.not.equal(option.value);
                customCommands.mutations.CHANGE_TYPE(state, option);
                expect(state.selectedCommand.description).to.not.equal(option.value);
            });

            it("should not change a field of selectedCommand if it is null", function () {
                let option = {
                    field: "description",
                    value: "new value"
                };
                state.selectedCommand = null;

                expect(() => customCommands.mutations.CHANGE_TYPE(state, option)).to.not.throw();
                expect(state.selectedCommand).to.be.null;
            });

            it("should require 'field' attribute in option parameter", function () {
                let option = {
                    value: "new value"
                };
                state.selectedCommand = CustomCommand.newInstance();

                expect(state.selectedCommand.description).to.not.equal(option.value);
                customCommands.mutations.CHANGE_TYPE(state, option);
                expect(state.selectedCommand.description).to.not.equal(option.value);
            });

            it("should require value attribute in option parameter", function () {
                let option = {
                    field: "description"
                };
                state.selectedCommand = CustomCommand.newInstance();

                expect(state.selectedCommand.description).to.not.equal(option.value);
                customCommands.mutations.CHANGE_TYPE(state, option);
                expect(state.selectedCommand.description).to.not.equal(option.value);
            });
        });
    });

    describe("actions", function () {
        describe("addCommand", function () {
            it("should commit ADD_ARRAY_OBJECT with id custom_commands and value of command parameter", function () {
                let commitStub = sinon.stub();
                state.selectedCommand = CustomCommand.newInstance();

                let data = {
                    state,
                    commit: commitStub,
                };
                let command = CustomCommand.newInstance();
                customCommands.actions.addCommand(data, command);
                expect(commitStub.args[0][0]).to.equal("ADD_ARRAY_OBJECT");
                expect(commitStub.args[0][1]).to.deep.equal({
                    id: "custom_commands",
                    value: command
                });
            });

            it("should commit ADD_ARRAY_OBJECT as a root commit", function () {
                let commitStub = sinon.stub();
                state.selectedCommand = CustomCommand.newInstance();

                let data = {
                    state,
                    commit: commitStub,
                };
                let command = CustomCommand.newInstance();
                customCommands.actions.addCommand(data, command);
                expect(commitStub.args[0][2]).to.deep.equal({root: true});
            });

            it("should commit SET_SELECTED_COMMAND with command", function () {
                let commitStub = sinon.stub();
                state.selectedCommand = CustomCommand.newInstance();

                let data = {
                    state,
                    commit: commitStub,
                };
                let command = CustomCommand.newInstance();
                customCommands.actions.addCommand(data, command);
                expect(commitStub.args[1][0]).to.equal("SET_SELECTED_COMMAND");
                expect(commitStub.args[1][1]).to.equal(command);
            });

            it("should commit ADD_ARRAY_OBJECT and SET_SELECTED_COMMAND if command is null", function () {
                let commitStub = sinon.stub();
                state.selectedCommand = null;

                let data = {
                    state,
                    commit: commitStub,
                };
                let command = CustomCommand.newInstance();
                customCommands.actions.addCommand(data, command);
                expect(commitStub.args[0][0]).to.equal("ADD_ARRAY_OBJECT");
                expect(commitStub.args[1][0]).to.equal("SET_SELECTED_COMMAND");
            });

            it("should commit ADD_ARRAY_OBJECT and SET_SELECTED_COMMAND if command is an empty object", function () {
                let commitStub = sinon.stub();
                state.selectedCommand = {};

                let data = {
                    state,
                    commit: commitStub,
                };
                let command = CustomCommand.newInstance();
                customCommands.actions.addCommand(data, command);
                expect(commitStub.args[0][0]).to.equal("ADD_ARRAY_OBJECT");
                expect(commitStub.args[1][0]).to.equal("SET_SELECTED_COMMAND");
            });
        });

        describe("deleteCommand", function () {
            it("should call config's find function", function () {
                let commitStub = sinon.stub();
                let findStub = sinon.stub();
                findStub.returns(ConfigData.newInstance("id", []));
                state.selectedCommand = CustomCommand.newInstance();

                let data = {
                    state,
                    commit: commitStub,
                    rootState: {
                        config: {
                            find: findStub
                        }
                    }
                };
                let command = CustomCommand.newInstance();
                customCommands.actions.deleteCommand(data, command);
                expect(findStub.args[0][0]).to.equal("custom_commands");
            });

            it("should delete a command if it is the selected one", function () {
                let commands = [
                    CustomCommand.newInstance("1"),
                    CustomCommand.newInstance("2"),
                    CustomCommand.newInstance("3")
                ];
                state.selectedCommand = commands[1];
                let commitStub = sinon.stub();
                let findStub = sinon.stub();
                let configData = ConfigData.newInstance("id", commands);
                findStub.returns(configData);

                let data = {
                    state,
                    commit: commitStub,
                    rootState: {
                        config: {
                            find: findStub
                        }
                    }
                };
                let command = CustomCommand.newInstance();
                customCommands.actions.deleteCommand(data, commands[1]);
                expect(configData.value.length).to.equal(2);
            });

            it("should commit SET_SELECTED_COMMAND if it is the selected command", function () {
                let commands = [
                    CustomCommand.newInstance("1"),
                    CustomCommand.newInstance("2"),
                    CustomCommand.newInstance("3")
                ];
                let commitStub = sinon.stub();
                let findStub = sinon.stub();
                findStub.returns(ConfigData.newInstance("id", commands));
                state.selectedCommand = commands[1];

                let data = {
                    state,
                    commit: commitStub,
                    rootState: {
                        config: {
                            find: findStub
                        }
                    }
                };
                let command = CustomCommand.newInstance();
                customCommands.actions.deleteCommand(data, commands[1]);
                expect(commitStub.args[0][0]).to.equal("SET_SELECTED_COMMAND");
            });

            it("should not commit SET_SELECTED_COMMAND if it not is the selected command", function () {
                let commands = [
                    CustomCommand.newInstance("1"),
                    CustomCommand.newInstance("2"),
                    CustomCommand.newInstance("3")
                ];
                let commitStub = sinon.stub();
                let findStub = sinon.stub();
                let configData = ConfigData.newInstance("id", commands);
                findStub.returns(configData);
                state.selectedCommand = commands[0];

                let data = {
                    state,
                    commit: commitStub,
                    rootState: {
                        config: {
                            find: findStub
                        }
                    }
                };
                let command = CustomCommand.newInstance();
                customCommands.actions.deleteCommand(data, commands[1]);
                expect(configData.value.length).to.equal(2);
                expect(commitStub.args[0]).to.be.undefined;
            });
        });

        describe("changeCommand", function () {
            it("should commit SET_SELECTED_COMMAND if it is a CustomCommand", function () {
                let commitStub = sinon.stub();
                let data = {
                    commit: commitStub,
                };
                let command = CustomCommand.newInstance();
                customCommands.actions.changeCommand(data, command);
                expect(commitStub.args[0][0]).to.equal("SET_SELECTED_COMMAND");
            });

            it("should not commit SET_SELECTED_COMMAND if it is null", function () {
                let commitStub = sinon.stub();
                let data = {
                    commit: commitStub,
                };
                let command = null;
                customCommands.actions.changeCommand(data, command);
                expect(commitStub.args[0]).to.be.undefined;
            });

            it("should not commit SET_SELECTED_COMMAND if it is an empty object", function () {
                let commitStub = sinon.stub();
                let data = {
                    commit: commitStub,
                };
                let command = {};
                customCommands.actions.changeCommand(data, command);
                expect(commitStub.args[0]).to.be.undefined;
            });
        });

        describe("changeField", function () {
            it("should throw error if field property does not exist on option parameter", function () {
                let commitStub = sinon.stub();
                let data = {
                    commit: commitStub,
                };
                let option = {
                    value: "value"
                };
                expect(() => customCommands.actions.changeField(data, option)).to.throw(TypeError, "Object does not have 'field' and 'value' fields");
            });

            it("should throw error if value property does not exist on option parameter", function () {
                let commitStub = sinon.stub();
                let data = {
                    commit: commitStub,
                };
                let option = {
                    field: "field"
                };
                expect(() => customCommands.actions.changeField(data, option)).to.throw(TypeError, "Object does not have 'field' and 'value' fields");
            });

            it("should throw error if field and value properties does not exist on option parameter", function () {
                let commitStub = sinon.stub();
                let data = {
                    commit: commitStub,
                };
                let option = {};
                expect(() => customCommands.actions.changeField(data, option)).to.throw(TypeError, "Object does not have 'field' and 'value' fields");
            });

            it("should commit CHANGE_TYPE with option parameter as value", function () {
                let commitStub = sinon.stub();
                let data = {
                    commit: commitStub,
                };
                let option = {
                    field: "field",
                    value: "value"
                };
                customCommands.actions.changeField(data, option);
                expect(commitStub.args[0][0]).to.equal("CHANGE_TYPE");
                expect(commitStub.args[0][1]).to.equal(option);
            });
        });
    });

    describe("getters", function () {
        describe("commands", function () {
            let state = {};
            let getters = {};
            let rootState = {
                config: null,
                guild: null
            };
            let rootGetters = {
                configInput: sinon.stub()
            };

            beforeEach(function () {
                rootState.config = new Config;
                rootState.guild = new Guild([],[], {id: "id", name: "name", icon: "icon"});
            });

            afterEach(function () {
                rootGetters.configInput.reset();
            });

            it("should return empty array if rootState.config not a Config instance", function () {
                rootState.config = null;
                expect(customCommands.getters.commands(state, getters, rootState, rootGetters)).to.be.an("array").that.is.empty;
                rootState.config = {};
                expect(customCommands.getters.commands(state, getters, rootState, rootGetters)).to.be.an("array").that.is.empty;
            });

            it("should return empty array if rootState.guild is not a Guild instance", function () {
                rootState.guild = null;
                expect(customCommands.getters.commands(state, getters, rootState, rootGetters)).to.be.an("array").that.is.empty;
                rootState.guild = {};
                expect(customCommands.getters.commands(state, getters, rootState, rootGetters)).to.be.an("array").that.is.empty;
            });

            it("should return empty array if rootState.config is not a Config instance or if rootState.guild is not a Guild instance", function () {
                rootState.config = null;
                rootState.guild = null;
                expect(customCommands.getters.commands(state, getters, rootState, rootGetters)).to.be.an("array").that.is.empty;
            });

            it("should call rootGetters.configInput with 'custom_commands' as parameter", function () {
                rootGetters.configInput.returns({value: null});
                customCommands.getters.commands(state, getters, rootState, rootGetters);
                expect(rootGetters.configInput.calledOnceWith("custom_commands"));
            });

            it("should return empty list if rootGetters.configInput with 'custom_commands' has null value property", function () {
                rootGetters.configInput.returns({value: null});
                expect(customCommands.getters.commands(state, getters, rootState, rootGetters)).to.be.an("array").that.is.empty;
            });

            it("should return the value property of rootGetters.configInput call with 'custom_commands' as parameter", function () {
                let value = "return value";
                rootGetters.configInput.returns({value: value});
                expect(customCommands.getters.commands(state, getters, rootState, rootGetters)).to.equal(value);
            });
        });
    });
});
