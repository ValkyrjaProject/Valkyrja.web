import sinon from "sinon";
import {expect} from "chai";
import ignoredChannels from "store/modules/IgnoredChannels";
import {Channel} from "../../../../resources/assets/js/models/Channel";
import {Guild} from "../../../../resources/assets/js/models/Guild";
import {Config} from "../../../../resources/assets/js/models/Config";
import {GuildChannel} from "../../../../resources/assets/js/models/GuildChannel";

describe("IgnoredChannels Vuex module", function () {
    let state = {};
    describe("state", function () {
        it("should be empty", function () {
            expect(ignoredChannels.state).to.deep.equal({});
        });
    });

    describe("mutations", function () {
        describe("CHANGE_IGNORED", function () {
            it("should set parameter payload.channel.ignored from payload.ignored", function () {
                let payload = {
                    channel: {
                        ignored: false,
                    },
                    ignored: true,
                };
                ignoredChannels.mutations.CHANGE_IGNORED(state, payload);
                expect(payload.channel.ignored).to.equal(payload.ignored);
            });
        });
    });

    describe("actions", function () {
        describe("addChannel", function () {
            it("throws exception if channel param is not instance of Channel", function () {
                expect(() => ignoredChannels.actions.addChannel(state, {})).to.throw(TypeError, "Object is not of type Channel");
            });

            it("should commit 'CHANGE_IGNORED' with channel param and ignored set to true", function () {
                let channel = new Channel;
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                expect(commitStub.calledOnce).to.be.false;
                ignoredChannels.actions.addChannel(data, channel);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.args[0][0]).to.equal("CHANGE_IGNORED");
                expect(commitStub.args[0][1]).to.deep.equal({channel: channel, ignored: 1});
            });
        });

        describe("removeChannel", function () {
            it("throws exception if channel param is not instance of Channel", function () {
                expect(() => ignoredChannels.actions.removeChannel(state, {})).to.throw(TypeError, "Object is not of type Channel");
            });

            it("should commit 'CHANGE_IGNORED' with channel param and ignored set to false", function () {
                let channel = new Channel;
                let commitStub = sinon.stub();
                let data = {
                    state,
                    commit: commitStub,
                };
                expect(commitStub.calledOnce).to.be.false;
                ignoredChannels.actions.removeChannel(data, channel);
                expect(commitStub.calledOnce).to.be.true;
                expect(commitStub.args[0][0]).to.equal("CHANGE_IGNORED");
                expect(commitStub.args[0][1]).to.deep.equal({channel: channel, ignored: 0});
            });
        });
    });

    describe("getters", function () {
        describe("availableChannels", function () {
            it("returns empty array if rootState.config is not an instance of Config", function () {
                let rootState = {
                    config: null,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                expect(ignoredChannels.getters.availableChannels(state, {}, rootState, {})).to.deep.equal([]);
            });

            it("returns empty array if rootState.guild is not an instance of Guild", function () {
                let rootState = {
                    config: new Config,
                    guild: null,
                };
                expect(ignoredChannels.getters.availableChannels(state, {}, rootState, {})).to.deep.equal([]);
            });

            it("calls 'configInput' root getter with 'channels'", function () {
                let rootState = {
                    config: new Config,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                rootGetters.configInput.returns({value:[]});
                expect(rootGetters.configInput.calledOnce, "configInput is not called before test").to.be.false;
                ignoredChannels.getters.availableChannels(state, {}, rootState, rootGetters);
                expect(rootGetters.configInput.calledOnce, "configInput was called").to.be.true;
                expect(rootGetters.configInput.args[0][0]).to.equal("channels");
            });

            it("should return list of configInput arrays if they exist in rootState.guild.channels and is not ignored", function () {
                let guildChannels = [];
                for (let i = 0; i < 50; i++) {
                    guildChannels.push(new GuildChannel(i.toString(), "name"));
                }

                let configInputChannels = [];
                for (let i = 10; i < 30; i++) {
                    configInputChannels.push({
                        id: i.toString(),
                        ignored: Math.round(Math.random()),
                    });
                }

                let rootState = {
                    config: new Config,
                    guild: new Guild([], guildChannels, {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                let value = {value: configInputChannels};
                rootGetters.configInput.returns(value);
                let response = ignoredChannels.getters.availableChannels(state, {}, rootState, rootGetters);
                expect(response.length).to.equal(configInputChannels.filter(c => !c.ignored).length);
                for (let i = 0; i < response.length; i++) {
                    expect(response[i]).to.have.property("ignored", 0);
                }
                expect(response).to.have.members(configInputChannels.filter(c => !c.ignored));
            });
        });

        describe("ignoredChannels", function () {
            it("returns empty array if rootState.config is not an instance of Config", function () {
                let rootState = {
                    config: null,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                expect(ignoredChannels.getters.ignoredChannels(state, {}, rootState, {})).to.deep.equal([]);
            });

            it("returns empty array if rootState.guild is not an instance of Guild", function () {
                let rootState = {
                    config: new Config,
                    guild: null,
                };
                expect(ignoredChannels.getters.ignoredChannels(state, {}, rootState, {})).to.deep.equal([]);
            });

            it("calls 'configInput' root getter with 'channels'", function () {
                let rootState = {
                    config: new Config,
                    guild: new Guild([], [], {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                rootGetters.configInput.returns({value:[]});
                expect(rootGetters.configInput.calledOnce, "configInput is not called before test").to.be.false;
                ignoredChannels.getters.ignoredChannels(state, {}, rootState, rootGetters);
                expect(rootGetters.configInput.calledOnce, "configInput was called").to.be.true;
                expect(rootGetters.configInput.args[0][0]).to.equal("channels");
            });

            it("should return list of configInput arrays if they exist in rootState.guild.channels and is not ignored", function () {
                let guildChannels = [];
                for (let i = 0; i < 50; i++) {
                    guildChannels.push(new GuildChannel(i.toString(), "name"));
                }

                let configInputChannels = [];
                for (let i = 10; i < 30; i++) {
                    configInputChannels.push({
                        id: i.toString(),
                        ignored: Math.round(Math.random()),
                    });
                }

                let rootState = {
                    config: new Config,
                    guild: new Guild([], guildChannels, {id:"", name:"", icon:""}),
                };
                let rootGetters = {
                    configInput: sinon.stub()
                };
                let value = {value: configInputChannels};
                rootGetters.configInput.returns(value);
                let response = ignoredChannels.getters.ignoredChannels(state, {}, rootState, rootGetters);
                expect(response.length).to.equal(configInputChannels.filter(c => c.ignored).length);
                for (let i = 0; i < response.length; i++) {
                    expect(response[i]).to.have.property("ignored", 1);
                }
                expect(response).to.have.members(configInputChannels.filter(c => c.ignored));
            });
        });
    });
});
