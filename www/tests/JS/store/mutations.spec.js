import sinon from "sinon";
import {expect} from "chai";
import {state, mutations} from "store/mutations";
import {ConfigData} from "../../../resources/assets/js/models/ConfigData";
import {Guild} from "../../../resources/assets/js/models/Guild";
import {Config} from "../../../resources/assets/js/models/Config";
import loglevel from "loglevel";
import lscache from "lscache";
import {Vue} from "vue";

describe("state", function () {
    it("should have empty array 'guilds'", function () {
        expect(state.guilds).to.deep.equal([]);
    });

    it("should have empty object 'guild'", function () {
        expect(state.guild).to.deep.equal({});
    });

    it("should have object 'user' with name and avatar fields", function () {
        expect(state.user).to.have.all.keys("name", "avatar");
    });

    it("should user.name field be null", function () {
        expect(state.user.name).to.be.null;
    });

    it("should user.avatar field be null", function () {
        expect(state.user.avatar).to.be.null;
    });
});

describe("mutations", function () {

    describe("ADD_GUILDS", function () {
        it("should create a Guild for each guild in guilds parameter and add the list to state.guilds", function () {
            let guilds = [{id: "1"}, {id: "2"}, {id: "3"}];
            let state = {guilds: []};

            let mock = sinon.stub(Guild, "createGuild");
            mock.withArgs(guilds[0]).returns(guilds[0]);
            mock.withArgs(guilds[1]).returns(guilds[1]);
            mock.withArgs(guilds[2]).returns(guilds[2]);

            mutations.ADD_GUILDS(state, guilds);

            expect(state.guilds.length).to.equal(guilds.length);
            for (let i = 0; i < state.length; i++) {
                expect(state.guilds[i].id).to.equal(guilds[i].id);
            }
            Guild.createGuild.restore();
        });

        it("should set empty list to state.guilds if no guilds exists", function () {
            let guilds = [];
            let state = {guilds: []};

            mutations.ADD_GUILDS(state, guilds);

            expect(state.guilds).to.deep.equal([]);
        });
    });

    describe("ADD_CONFIG", function () {
        let createGuildStub;
        let instanceFromApiStub;
        let addGuildDataStub = sinon.stub();

        beforeEach(function () {
            addGuildDataStub.resetHistory();
            createGuildStub = sinon.stub(Guild, "createGuild");
            createGuildStub.returns("test guild");

            instanceFromApiStub = sinon.stub(Config, "instanceFromApi");
            instanceFromApiStub.returns({addGuildData: addGuildDataStub});
        });

        afterEach(function () {
            createGuildStub.restore();
            instanceFromApiStub.restore();
        });

        it("should create a global Guild and set it to state.guild", function () {
            let configData = {
                guild: {},
                config: {},
            };
            let state = {
                guild: {},
                config: {},
            };

            mutations.ADD_CONFIG(state, configData);

            expect(createGuildStub.withArgs(configData.guild, true).calledOnce, "createGuild called once").to.be.true;
            expect(state.guild).to.equal("test guild");
        });

        it("should create a Config and set it to state.config", function () {
            let configData = {
                guild: {},
                config: {},
            };
            let state = {
                guild: {},
                config: {},
            };

            mutations.ADD_CONFIG(state, configData);

            expect(instanceFromApiStub.withArgs(configData.config).calledOnce, "instanceFromApiStub called once").to.be.true;
            expect(state.config).to.deep.equal({addGuildData: addGuildDataStub});
        });

        it("should call Config addGuildData() with Guild instance parameter", function () {
            let configData = {
                guild: {},
                config: {},
            };
            let state = {
                guild: {},
                config: {},
            };

            mutations.ADD_CONFIG(state, configData);

            expect(addGuildDataStub.withArgs("test guild").calledOnce, "addGuildDataStub called once").to.be.true;
            expect(state.config).to.deep.equal({addGuildData: addGuildDataStub});
        });
    });

    describe("ADD_USER", function () {
        it("should set state.user to user parameter", function () {
            let state = {user: null};
            let user = "user";
            mutations.ADD_USER(state, user);
            expect(state.user).to.equal(user);
        });
    });

    describe("INITIALIZE_USER", function () {
        let lscache_stub = sinon.stub(lscache, "get");

        beforeEach(function () {
            lscache_stub.reset();
        });

        it("should set unserialized JSON data to state.user from lscache.get('user') if it exists", function () {
            let user = {username: "name"};
            let state = {user: null};
            lscache_stub.withArgs("user").returns(JSON.stringify(user));
            mutations.INITIALIZE_USER(state, user);
            expect(lscache_stub.withArgs("user").calledTwice, "lscache.get('user') was called").to.be.true;
            expect(state.user).to.eql(user);
        });

        it("should not set data to state.user if lscache.get('user') does not exist", function () {
            let user = {username: "name"};
            let state = {user: null};
            lscache_stub.withArgs("user").returns(undefined);
            mutations.INITIALIZE_USER(state, user);
            expect(lscache_stub.withArgs("user").calledOnce, "lscache.get('user') was called").to.be.true;
            expect(state.user).to.be.null;
        });
    });

    describe("CHANGE_CONFIG", function () {
        let vue_stub = sinon.stub();
        let state;
        before(function () {
            global.Vue = {set: vue_stub};
            state = {
                config: {
                    find: sinon.stub(),
                }
            };
        });

        beforeEach(function () {
            vue_stub.reset();
            state.config.find.reset();
        });

        it("should have configData parameter with storeName and value fields", function () {
            let state = {
                config: {
                    find: sinon.stub(),
                }
            };
            const configData = {
                storeName: "name",
                value: "value"
            };
            let returnValue = new ConfigData;
            state.config.find.returns(returnValue);
            mutations.CHANGE_CONFIG(state, configData);
            expect(state.config.find.calledOnceWith(configData.storeName), "calls config.find() once").to.be.true;
            expect(vue_stub.calledWithMatch(sinon.match.any, sinon.match.any, configData.value), "calls Vue.set() with configData.value field").to.be.true;
        });

        it("should throw TypeError if storeName and value fields doesn't exist", function () {
            let state = {
                config: {
                    find: sinon.stub(),
                }
            };

            let configData = {};
            expect(() => mutations.CHANGE_CONFIG(state, configData)).to.throw(TypeError, "Object does not have 'storeName' and 'value' fields");

            configData = {
                storeName: "name"
            };
            expect(() => mutations.CHANGE_CONFIG(state, configData)).to.throw(TypeError, "Object does not have 'storeName' and 'value' fields");
            configData = {
                value: "value"
            };
            expect(() => mutations.CHANGE_CONFIG(state, configData)).to.throw(TypeError, "Object does not have 'storeName' and 'value' fields");
            configData = {
                storeName: "name",
                value: "value"
            };
            expect(() => mutations.CHANGE_CONFIG(state, configData)).to.not.throw();
        });

        it("should call Vue.set with returned config.find, 'value', and configData.value parameters", function () {
            let state = {
                config: {
                    find: sinon.stub(),
                }
            };
            const configData = {
                storeName: "name",
                value: "value"
            };
            let returnValue = new ConfigData;
            state.config.find.returns(returnValue);
            mutations.CHANGE_CONFIG(state, configData);
            expect(vue_stub.calledOnceWith(returnValue, "value", configData.value), "calls Vue.set() with config.find, 'value', and configData.value parameters").to.be.true;
        });
    });

    describe("ADD_ARRAY_OBJECT", function () {
        let state;
        let vue_stub = sinon.stub();

        before(function () {
            global.Vue = {set: vue_stub};
            state = {
                config: {
                    find: sinon.stub(),
                    config_data: []
                },
            };
        });

        beforeEach(function () {
            vue_stub.reset();
            state.config.find.reset();
        });

        it("should find ConfigData from state.config based on payload.id parameter", function () {
            let payload = ConfigData.newInstance(
                "id",
                "value"
            );
            let returnObject = new ConfigData();
            returnObject.value = [];
            state.config.find.withArgs(payload.id).returns(returnObject);
            mutations.ADD_ARRAY_OBJECT(state, payload);
            expect(state.config.find.calledOnceWith(payload.id)).to.be.true;
            expect(vue_stub.called, "doesn't call Vue.set()").to.be.false;
        });

        it("should push payload.value to the array's value field if it is a ConfigData and it's value field is an Array", function () {
            let payload = ConfigData.newInstance(
                "id",
                "value"
            );
            let returnObject = new ConfigData();
            returnObject.value = [];
            state.config.find.withArgs(payload.id).returns(returnObject);
            mutations.ADD_ARRAY_OBJECT(state, payload);
            expect(returnObject.value).to.eql([payload.value]);
            expect(vue_stub.called, "doesn't call Vue.set()").to.be.false;
        });

        it("should create a new ConfigData instance from newInstance() function if payload.value is a ConfigData field", function () {
            let payload = ConfigData.newInstance(
                "id",
                new ConfigData
            );
            let returnObject = {};
            state.config.find.withArgs(payload.id).returns(returnObject);
            mutations.ADD_ARRAY_OBJECT(state, payload);
            expect(vue_stub.calledOnceWith(state.config.config_data, payload.id, sinon.match.instanceOf(ConfigData)), "calls Vue.set() with state.config.config_data, payload.id, and new ConfigData instance").to.be.true;
            expect(vue_stub.args[0][2].value, "sets new ConfigData value field to array with payload value as only entry").to.eql([payload.value]);
        });

        it("should throw TypeError if config.find() can't be found and payload.value isn't a ConfigData instance", function () {
            let payload = ConfigData.newInstance(
                "id",
                "value"
            );
            state.config.find.withArgs(payload.id).returns(null);
            expect(() => mutations.ADD_ARRAY_OBJECT(state, payload)).to.throw(Error, "Cannot add object. Array does not exist or payload.value is not of ConfigData instance.");
        });

        it("should throw TypeError if payload.value is not an Array and payload.value isn't a ConfigData instance", function () {
            let payload = ConfigData.newInstance(
                "id",
                "value"
            );
            let returnObject = {};
            state.config.find.withArgs(payload.id).returns(returnObject);
            expect(() => mutations.ADD_ARRAY_OBJECT(state, payload)).to.throw(Error, "Cannot add object. Array does not exist or payload.value is not of ConfigData instance.");
        });
    });
});
