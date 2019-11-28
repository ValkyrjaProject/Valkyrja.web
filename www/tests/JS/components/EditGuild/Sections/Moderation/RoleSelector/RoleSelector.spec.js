import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import RoleSelector from "../../../../../../../resources/assets/js/components/EditGuild/Sections/Moderation/RoleSelector/RoleSelector";
import RoleSelectorType from "../../../../../../../resources/assets/js/components/EditGuild/Sections/Moderation/RoleSelector/RoleSelectorType";
import PanelList from "../../../../../../../resources/assets/js/components/shared/structure/PanelList/PanelList";
import {PublicRole} from "../../../../../../../resources/assets/js/models/PublicRole";

let localVue = Vue.use(Vuex);

describe("RoleSelector", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;
    let types;

    beforeEach(function () {
        propsData = {};
        actions = {
            addRole: sinon.stub(),
            removeRole: sinon.stub(),
        };
        types =  {
            Public: 1,
            Member: 2,
            SubModerator: 3,
            Moderator: 4,
            Admin: 5
        };
        state = {
            roles: [],
            availableRoles: [],
            addedRoles: [],
            selectedType: types.Public,
        };
        getters = {
            availableRoles: () => state.availableRoles,
            addedRoles: () => () => state.addedRoles,
        };
        store = new Vuex.Store({
            modules: {
                roleSelector: {
                    namespaced: true,
                    state,
                    actions,
                    getters
                }
            }
        });
        wrapper = shallowMount(RoleSelector, {propsData, store, localVue});
    });

    it("should have 1 RoleSelectorType", function () {
        expect(wrapper.findAll(RoleSelectorType).length).to.equal(1);
    });

    it("should have 2 PanelLists", function () {
        expect(wrapper.findAll(PanelList).length).to.equal(2);
    });

    it("sends available roles to left panel-list", function () {
        expect(wrapper.findAll(PanelList).at(0).props().value).to.equal(getters.availableRoles());
        state.availableRoles.push(PublicRole.createNewRole(1));
        state.availableRoles.push(PublicRole.createNewRole(2));
        expect(wrapper.findAll(PanelList).at(0).props().value).to.equal(getters.availableRoles());
    });

    it("sends added roles to right panel-list", function () {
        expect(wrapper.findAll(PanelList).at(1).props().value).to.equal(getters.addedRoles()());
        state.addedRoles.push(PublicRole.createNewRole(1));
        state.addedRoles.push(PublicRole.createNewRole(2));
        expect(wrapper.findAll(PanelList).at(1).props().value).to.equal(getters.addedRoles()());
    });

    it("should not dispatch add role when availableRoles is not called", function () {
        expect(actions.addRole.calledOnce).to.equal(false);
    });

    it("should dispatch add role when availableRoles is called", function () {
        wrapper.vm.availableRoles = "Test";
        expect(actions.addRole.calledOnce).to.equal(true);
    });

    it("should dispatch remove role when addedRoles is called", function () {
        wrapper.vm.addedRoles = "Test";
        expect(actions.removeRole.calledOnce).to.equal(true);
    });

    it("should not dispatch remove role when addedRoles is not called", function () {
        expect(actions.removeRole.calledOnce).to.equal(false);
    });

    it("should display everything in a box", function () {
        expect(wrapper.classes()).to.contain("box");
    });

    it("should have 3 columns in box", function () {
        expect(wrapper.find(".box").findAll(".columns > .column").length).to.equal(3);
    });

    it("should have name of RoleSelector", function () {
        expect(wrapper.name()).to.equal("RoleSelector");
    });
});
