import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import LevelSelector from "components/EditGuild/Sections/Social/LevelSelector/LevelSelector";
import PanelList from "components/shared/structure/PanelList/PanelList";
import LevelSelectorInput from "components/EditGuild/Sections/Social/LevelSelector/LevelSelectorInput";

let localVue = Vue.use(Vuex);

describe("LevelSelector", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;

    beforeEach(function () {
        propsData = {};
        actions = {
            changeRoleLevel: sinon.stub(),
        };
        state = {
            selectedLevel: null,
            availableRoles: [],
            addedRoles: [],
        };
        getters = {
            availableRoles: () => state.availableRoles,
            addedRoles: () => state.addedRoles,
        };
        store = new Vuex.Store({
            modules: {
                levelSelector: {
                    namespaced: true,
                    state,
                    actions,
                    getters
                }
            }
        });
        wrapper = shallowMount(LevelSelector, {propsData, store, localVue});
    });

    it("should have a box class with columns class element under it", function () {
        expect(wrapper.find(".box").findAll(".columns").exists()).to.be.true;
    });

    it("should have three columns under columns class", function () {
        let columns = wrapper.find(".columns").findAll(".column");
        expect(columns).to.have.length(3);
    });

    it("should have LevelSelectorInput on first column with is-one-third class", function () {
        expect(wrapper.findAll(".column").at(0).classes()).to.contain("is-one-third");
    });

    it("should have available roles on second column with is-one-third class", function () {
        expect(wrapper.findAll(".column").at(1).classes()).to.contain("is-one-third");
    });

    it("should have added roles on third column with is-one-third class", function () {
        expect(wrapper.findAll(".column").at(2).classes()).to.contain("is-one-third");
    });

    it("should have is-fullwidth class on second column", function () {
        expect(wrapper.findAll(".column").at(1).find(".is-fullwidth").exists()).to.be.true;
    });

    it("should have is-fullwidth class on third column", function () {
        expect(wrapper.findAll(".column").at(2).find(".is-fullwidth").exists()).to.be.true;
    });

    it("should have a LevelSelectorInput in first column", function () {
        expect(wrapper.findAll(".column").at(0).find(LevelSelectorInput).exists()).to.be.true;
    });

    it("should have a PanelList in second column", function () {
        expect(wrapper.findAll(".column").at(1).find(PanelList).exists()).to.be.true;
    });

    it("should have a PanelList in third column", function () {
        expect(wrapper.findAll(".column").at(2).find(PanelList).exists()).to.be.true;
    });

    it("should send in 'Available roles' as title to second column's PanelList", function () {
        let panelList = wrapper.findAll(".column").at(1).find(PanelList);
        expect(panelList.props().title).to.equal("Available roles");
    });

    it("should send in 'Roles added to level' as title to third column's PanelList", function () {
        let panelList = wrapper.findAll(".column").at(2).find(PanelList);
        expect(panelList.props().title).to.equal("Roles added to level");
    });

    it("should send getter levelSelector/availableRoles to second column's PanelList", function () {
        state.availableRoles = [
            {value: "new available role"}
        ];
        let panelList = wrapper.findAll(".column").at(1).find(PanelList);
        expect(panelList.props().value).to.deep.equal(state.availableRoles);
    });

    it("should send getter levelSelector/addedRoles to third column's PanelList", function () {
        state.addedRoles = [
            {value: "new added role"}
        ];
        let panelList = wrapper.findAll(".column").at(2).find(PanelList);
        expect(panelList.props().value).to.deep.equal(state.addedRoles);
    });

    it("should dispatch changeRoleLevel when second column's PanelList emits input", function () {
        let panelList = wrapper.findAll(".column").at(1).find(PanelList);
        let role = "new role";
        state.selectedLevel = 5;
        panelList.vm.$emit("input", role);
        expect(actions.changeRoleLevel.calledOnce).to.be.true;
        expect(actions.changeRoleLevel.getCall(0).args[1]).to.deep.equal({
            role,
            level: state.selectedLevel
        });
    });

    it("should dispatch changeRoleLevel when third column's PanelList emits input", function () {
        let panelList = wrapper.findAll(".column").at(2).find(PanelList);
        let role = "new role";
        state.selectedLevel = 5;
        panelList.vm.$emit("input", role);
        expect(actions.changeRoleLevel.calledOnce).to.be.true;
        expect(actions.changeRoleLevel.getCall(0).args[1]).to.deep.equal({
            role,
            level: 0
        });
    });
});
