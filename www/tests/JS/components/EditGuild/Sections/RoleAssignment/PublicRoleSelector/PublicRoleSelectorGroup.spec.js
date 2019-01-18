import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import PublicRoleSelectorGroup from "components/EditGuild/Sections/RoleAssignment/PublicRoleSelector/PublicRoleSelectorGroup";
import PublicGroup from "models/PublicGroup";
import {BlankPublicGroup} from "models/BlankPublicGroup";

let localVue = Vue.use(Vuex);

describe("PublicRoleSelectorGroup", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;
    let heading;
    let types;

    beforeEach(function () {
        heading = "example header";
        propsData = {
            title: heading
        };

        actions = {
            addPublicGroup: sinon.mock(),
            selectedPublicGroup: sinon.mock()
        };
        types =  {
            Public: 1,
            Member: 2,
            SubModerator: 3,
            Moderator: 4,
            Admin: 5
        };
        state = {
            selectedType: types.Public,
            publicGroups: [],
            selectedPublicGroup: BlankPublicGroup.instance,
            types: {
                Public: 1,
                Member: 2,
                SubModerator: 3,
                Moderator: 4,
                Admin: 5
            },
        };
        getters = {
            publicGroups: () => state.publicGroups
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
        wrapper = shallowMount(PublicRoleSelectorGroup, {propsData, store, localVue});
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

    it("should dispatch addPublicGroup when add button is clicked when Public type is selected", function () {
        state.selectedType = types.Public;
        wrapper.find(".add-public-group").trigger("click");
        expect(actions.addPublicGroup.calledOnce).to.equal(true);
    });

    it("should dispatch selectedPublicGroup when add button is clicked when Public type is selected", function () {
        state.selectedType = types.Public;
        wrapper.find(".add-public-group").trigger("click");
        expect(actions.selectedPublicGroup.calledOnce).to.equal(true);
    });

    it("should not dispatch actions when add button is clicked when non-Public types are selected", function () {
        for (let typesKey in types) {
            if (types[typesKey] === types.Public) continue;

            state.selectedType = types[typesKey];
            wrapper.find(".add-public-group").trigger("click");

            expect(actions.addPublicGroup.called).to.equal(false);
            expect(actions.selectedPublicGroup.called).to.equal(false);
        }
    });

    it("should display all groups with name and value", function () {
        state.publicGroups.push(PublicGroup.createInstance(1));
        state.publicGroups.push(PublicGroup.createInstance(2));
        state.publicGroups.push(PublicGroup.createInstance(3));
        let groupsWrapper = wrapper.findAll("option");
        expect(groupsWrapper.length).to.equal(state.publicGroups.length + 1);

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
        wrapper.find(".add-public-group").trigger("click");
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

    it("should display groups in rising group-id order with No Group at top of list", function () {
        state.publicGroups.push(PublicGroup.createInstance(2));
        state.publicGroups.push(PublicGroup.createInstance(1));
        state.publicGroups.push(PublicGroup.createInstance(3));

        let groupsWrapper = wrapper.findAll("option");
        expect(groupsWrapper.at(0).text()).to.equal(BlankPublicGroup.instance.toString());
        expect(groupsWrapper.at(1).text()).to.equal(state.publicGroups[1].toString());
        expect(groupsWrapper.at(2).text()).to.equal(state.publicGroups[0].toString());
        expect(groupsWrapper.at(3).text()).to.equal(state.publicGroups[2].toString());
    });

    it("should display group name input", function () {
        expect(wrapper.find("input.groupName").exists()).to.equal(true);
    });

    it("should display role limit input", function () {
        expect(wrapper.find("input.roleLimit").exists()).to.equal(true);
    });

    it("should disable group name input when non-Public type is selected", function () {
        for (let typesKey in types) {
            if (types[typesKey] === types.Public) continue;

            state.selectedType = types[typesKey];
            expect(wrapper.find("input.groupName").element.disabled).to.equal(true);
        }
    });

    it("should disable role limit input when non-Public type is selected", function () {
        for (let typesKey in types) {
            if (types[typesKey] === types.Public) continue;

            state.selectedType = types[typesKey];
            expect(wrapper.find("input.roleLimit").element.disabled).to.equal(true);
        }
    });

    it("should disable group name when Public type and No Group is selected", function () {
        state.selectedType = types.Public;
        expect(state.selectedPublicGroup).to.equal(BlankPublicGroup.instance);
        expect(wrapper.find("input.groupName").element.disabled).to.equal(true);
    });

    it("should disable role limit when Public type and No Group is selected", function () {
        state.selectedType = types.Public;
        expect(state.selectedPublicGroup).to.equal(BlankPublicGroup.instance);
        expect(wrapper.find("input.roleLimit").element.disabled).to.equal(true);
    });

    it("should enable group name when Public type and a public group is selected", function () {
        state.selectedType = types.Public;
        state.publicGroups.push(PublicGroup.createInstance(1));
        state.selectedPublicGroup = state.publicGroups[0];
        expect(wrapper.find("input.groupName").element.disabled).to.equal(false);
    });

    it("should enable role limit when Public type and a public group is selected", function () {
        state.selectedType = types.Public;
        state.publicGroups.push(PublicGroup.createInstance(1));
        state.selectedPublicGroup = state.publicGroups[0];
        expect(wrapper.find("input.roleLimit").element.disabled).to.equal(false);
    });

    it("should show empty group name when non-PublicGroup instance is added", function () {
        state.selectedType = types.Public;
        state.publicGroups.push({name: "name"});
        state.selectedPublicGroup = state.publicGroups[0];
        expect(wrapper.find("input.groupName").text()).to.equal("");
    });

    it("should show empty role limit when non-PublicGroup instance is added", function () {
        state.selectedType = types.Public;
        state.publicGroups.push({name: "name"});
        state.selectedPublicGroup = state.publicGroups[0];
        expect(wrapper.find("input.roleLimit").text()).to.equal("");
    });
});
