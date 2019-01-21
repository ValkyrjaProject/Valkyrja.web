import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import ReactionRoles from "components/EditGuild/Sections/RoleAssignment/ReactionRoles/ReactionRoles";

let localVue = Vue.use(Vuex);

describe("ReactionRoles", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;

    beforeEach(function () {
        propsData = {};

        actions = {
            addReactionRole: sinon.stub(),
        };
        state = {
            roles: [],
        };
        getters = {
            roles: () => state.roles,
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
        wrapper = shallowMount(ReactionRoles, {propsData, store, localVue});
    });

    describe("styling", function () {
        it("should have a box with white background", function () {
            expect(wrapper.find(".box.has-background-white-bis").exists()).to.be.true;
        });

        it("should should have columns directly in box", function () {
            expect(wrapper.find(".box > .columns").exists()).to.be.true;
        });

        it("should have PanelList as first column", function () {
            expect(wrapper.findAll(".columns > .column").at(0).find("panellist-stub").exists()).to.be.true;
        });

        it("should send 'Messages' into PanelList's title field", function () {
            expect(wrapper.find("panellist-stub").attributes("title")).to.equal("Messages");
        });

        it("should have ReactionRolesForm as second column", function () {
            expect(wrapper.findAll(".columns > .column").at(1).find("reactionrolesform-stub").exists()).to.be.true;
        });

        it("should have one third on first column", function () {
            expect(wrapper.findAll(".columns > .column").at(0).classes()).to.contain("is-one-third");
        });

        it("should have two third's on second  column", function () {
            expect(wrapper.findAll(".columns > .column").at(1).classes()).to.contain("is-two-thirds");
        });
    });

    it("should retrieve reaction roles from getter when calling reactionRoles", function () {
        state.roles = ["test data"];
        expect(wrapper.vm.reactionRoles).to.equal(state.roles);
    });

    it("should dispatch reactionRoles/addReactionRole when new value is set on reactionRoles", function () {
        wrapper.vm.reactionRoles = "new value";
        expect(actions.addReactionRole.calledOnce).to.be.true;
        expect(actions.addReactionRole.getCall(0).args[1]).to.equal("new value");
    });
});
