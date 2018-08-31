import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import RoleSelectorGroup from "components/EditGuild/Sections/Moderation/RoleSelector/RoleSelectorGroup";
import PublicGroup from "../../../../../../../resources/assets/js/models/PublicGroup";

let localVue = Vue.use(Vuex);

describe("RoleSelectorGroup", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;
    let heading;

    beforeEach(function () {
        heading = "example header";
        propsData = {
            title: heading
        };

        actions = {
            addPublicGroup: sinon.mock(),
            selectedPublicGroup: sinon.mock()
        };
        state = {
            publicGroups: [],
            selectedPublicGroup: null
        };
        getters = {};
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
        wrapper = shallowMount(RoleSelectorGroup, {propsData, store, localVue});
    });

    it("should display panel", function () {
        expect(wrapper.find("nav.panel").exists()).to.equal(true);
    });

    it("should display a select field", function () {
        expect(wrapper.find(".select select").exists()).to.equal(true);
    });

    it("should display title as panel-heading from title prop", function () {
        expect(wrapper.find(".panel-heading").text()).to.equal(heading);
    });

    it("should display plus-button for adding new group", function () {
        expect(wrapper.find("a.button .mdi.mdi-plus").exists()).to.equal(true);
    });

    it("should dispatch addPublicGroup when add button is clicked", function () {
        wrapper.find(".button .mdi").trigger("click");
        expect(actions.addPublicGroup.calledOnce).to.equal(true);
    });

    it("should dispatch selectedPublicGroup when add button is clicked", function () {
        wrapper.find(".button .mdi").trigger("click");
        expect(actions.selectedPublicGroup.calledOnce).to.equal(true);
    });

    it("should display all groups from Vuex with name and value", function () {
        state.publicGroups.push(PublicGroup.createInstance(1));
        state.publicGroups.push(PublicGroup.createInstance(2));
        state.publicGroups.push(PublicGroup.createInstance(3));
        console.log(wrapper.find("select").html());
        for (let group of state.publicGroups) {
            console.log(group.id);
        }
        console.log(state.publicGroups);
        let groupsWrapper = wrapper.findAll("option");
        expect(groupsWrapper.length).to.equal(state.publicGroups.length);

        for (let group of state.publicGroups) {
            let filteredWrapper = groupsWrapper.filter((groupWrapper) => {
                return groupWrapper.text() === group.toString();
            });
            expect(filteredWrapper.exists()).to.equal(true);
        }
    });

    it("should take title as a required prop", function () {
        let title = wrapper.vm.$options.props.title;
        expect(title.required).to.equal(true);
    });

    it("should not add new group if isActive prop is false", function () {
        wrapper.setProps({
            isActive: false
        });
        wrapper.find(".button .mdi").trigger("click");
        expect(actions.selectedPublicGroup.notCalled).to.equal(true);
    });

    it("should dispatch selectedPublicGroup when changing group", function () {
        wrapper.vm.selectedPublicGroup = PublicGroup.createInstance(1);
        expect(actions.selectedPublicGroup.calledOnce).to.equal(true);
    });

    it("should display selected Public Group from state", function () {
        state.publicGroups.push(PublicGroup.createInstance(1));
        state.publicGroups.push(PublicGroup.createInstance(2));
        state.publicGroups.push(PublicGroup.createInstance(3));

        let selectedGroup = state.publicGroups[1];
        expect(wrapper.find("select").element.value).to.not.equal(selectedGroup.toString());
        state.selectedPublicGroup = selectedGroup;
        expect(wrapper.find("select").element.value).to.equal(selectedGroup.toString());
    });

    it("should display groups in rising group-id order", function () {
        state.publicGroups.push(PublicGroup.createInstance(2));
        state.publicGroups.push(PublicGroup.createInstance(1));
        state.publicGroups.push(PublicGroup.createInstance(3));

        let groupsWrapper = wrapper.findAll("option");
        expect(state.publicGroups[0].toString()).to.equal(groupsWrapper.at(1).text());
        expect(state.publicGroups[1].toString()).to.equal(groupsWrapper.at(0).text());
        expect(state.publicGroups[2].toString()).to.equal(groupsWrapper.at(2).text());
    });
});
