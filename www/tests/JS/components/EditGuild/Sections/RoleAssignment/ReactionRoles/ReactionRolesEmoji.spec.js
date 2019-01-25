import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import ReactionRolesEmoji from "components/EditGuild/Sections/RoleAssignment/ReactionRoles/ReactionRolesEmoji";
import ReactionRole from "../../../../../../../resources/assets/js/models/ReactionRole";

let localVue = Vue.use(Vuex);

describe("ReactionRolesEmoji", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;

    beforeEach(function () {
        propsData = {};

        actions = {
            changeField: sinon.stub(),
            addRole: sinon.stub(),
            removeRole: sinon.stub(),
        };
        state = {
            availableRoles: [],
            addedRoles: [],
            selectedRole: ReactionRole.newInstance("id", []),
        };
        getters = {
            availableRoles: () => state.availableRoles,
            addedRoles: () => state.addedRoles,
        };
        store = new Vuex.Store({
            modules: {
                reactionRoles: {
                    namespaced: true,
                    state,
                    actions,
                    getters
                }
            }
        });
        wrapper = shallowMount(ReactionRolesEmoji, {propsData, store, localVue, stubs: ["PanelList"]});
    });

    describe("styling", function () {
        it("should have two columns under root element", function () {
            expect(wrapper.findAll(".columns.is-root > .column")).to.have.length(2);
        });

        it("should have is-desktop class in root object for wrapping in smaller sizes earlier", function () {
            expect(wrapper.classes("is-desktop")).to.be.true;
        });

        it("should have gapless root element", function () {
            expect(wrapper.classes("is-gapless")).to.be.true;
        });

        describe("first column", function () {
            beforeEach(function () {
                wrapper = wrapper.findAll(".columns.is-root > .column").at(0);
            });

            it("should have two PanelList columns", function () {
                let panelLists = wrapper.findAll("panellist-stub");
                expect(panelLists).to.have.length(2);
                expect(panelLists.at(0).classes()).to.contain("column");
                expect(panelLists.at(1).classes()).to.contain("column");
            });

            it("should be marginless", function () {
                expect(wrapper.classes("is-marginless")).to.be.true;
            });

            it("should be gapless", function () {
                expect(wrapper.classes("is-gapless")).to.be.true;
            });

            it("should have two columns with half-width", function () {
                expect(wrapper.findAll(".columns > .column.is-half")).to.have.length(2);
            });

            it("should have title 'Available Roles' for first PanelList", function () {
                expect(wrapper.findAll("panellist-stub").at(0).props("title")).to.equal("Available Roles");
            });

            it("should have title 'Added Roles' for second PanelList", function () {
                expect(wrapper.findAll("panellist-stub").at(1).props("title")).to.equal("Added Roles");
            });
        });

        describe("second column", function () {
            beforeEach(function () {
                wrapper = wrapper.findAll(".columns.is-root > .column").at(1);
            });

            it("should have be a third in size", function () {
                expect(wrapper.classes("is-one-third")).to.be.true;
            });

            it("should have is-full-touch class", function () {
                expect(wrapper.classes("is-full-touch")).to.be.true;
            });

            it("should have a .panel element", function () {
                expect(wrapper.find(".column > .panel").exists()).to.be.true;
            });

            it("should have one .panel-block element under .panel", function () {
                expect(wrapper.findAll(".column > .panel > .panel-block")).to.have.length(1);
            });

            it("should have a link to emojipedia", function () {
                expect(wrapper.find(".panel a").attributes("href")).to.equal("https://emojipedia.org");
            });

            it("should open link to emojipedia in new page", function () {
                expect(wrapper.find(".panel a").attributes("target")).to.equal("_blank");
            });

            it("should have label for input field with description", function () {
                wrapper = wrapper.find(".panel-block > .control");
                expect(wrapper.find("label").attributes("for"), "label points to input").to.equal(wrapper.find("input.input").attributes("id"));
                expect(wrapper.find("label").text()).to.equal("Emoji - Either a CustomEmoji without colons, or a standard unicode emoji 🙃");
            });

            it("should has a text input field", function () {
                expect(wrapper.find(".panel-block input.input").attributes("type")).to.equal("text");
            });
        });
    });

    it("should dispatch reactionRoles/addRole when first PanelList emits input", function () {
        let panelList = wrapper.findAll("panellist-stub").at(0);
        panelList.vm.$emit("input", "new value");
        expect(actions.addRole.calledOnce).to.be.true;
        expect(actions.addRole.getCall(0).args[1]).to.equal("new value");
    });

    it("should dispatch reactionRoles/removeRole when second PanelList emits input", function () {
        let panelList = wrapper.findAll("panellist-stub").at(1);
        panelList.vm.$emit("input", "new value");
        expect(actions.removeRole.calledOnce).to.be.true;
        expect(actions.removeRole.getCall(0).args[1]).to.equal("new value");
    });

    it("should dispatch reactionRoles/changeEmoji when emoji is called", function () {
        wrapper.vm.emoji = "new value";
        expect(actions.changeField.calledOnce, "changeEmoji called once").to.be.true;
        expect(actions.changeField.getCall(0).args[1], "changeEmoji was called with new value").to.eql({
            field: "emoji",
            value: "new value"
        });
    });

    it("should retrieve emoji from state's emoji field", function () {
        state.selectedRole.emoji = "value";
        expect(wrapper.vm.emoji).to.equal(state.selectedRole.emoji);
    });
});
