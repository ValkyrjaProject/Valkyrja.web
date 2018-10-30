import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import PanelList from "components/shared/structure/PanelList/PanelList";
import PanelListSearch from "components/shared/structure/PanelList/PanelListSearch";
import PanelListItem from "components/shared/structure/PanelList/PanelListItem";

let localVue = Vue.use(Vuex);

describe("PanelList", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;

    beforeEach(function () {
        propsData = {
            title: "title",
            value: [{name: "value1"}, {name: "value2"}]
        };

        actions = {};
        state = {};
        getters = {};
        store = new Vuex.Store({
            state,
            actions,
            getters
        });
        wrapper = shallowMount(PanelList, {propsData, store, localVue});
    });

    it("should have 2 nav elements under root element by default", function () {
        expect(wrapper.findAll("div > nav").length).to.equal(2);
    });

    it("should have '.panel-parent' class on first nav element", function () {
        expect(wrapper.findAll("nav").at(0).classes()).to.contain("panel-parent");
    });

    it("should have '.is-fixed-height' and '.has-background-white' classes on second nav element", function () {
        let classes = wrapper.findAll("nav").at(1).classes();
        expect(classes).to.contain("is-fixed-height");
        expect(classes).to.contain("has-background-white");
    });

    it("should have '.panel-heading' under '.panel-parent' with title prop displayed", function () {
        expect(wrapper.find(".panel-parent > .panel-heading").text()).to.equal(propsData.title);
    });

    it("should not display '.panel-heading' if title prop is null", function () {
        wrapper.setProps({title:null});
        expect(wrapper.find(".panel-heading").exists()).to.equal(false);
    });

    it("should display PanelListSearch component under first '.panel-parent'", function () {
        expect(wrapper.findAll(".panel-parent").at(0).find(PanelListSearch).exists()).to.be.true;
    });

    it("should display PanelListItem component for each entry in searchedList by default", function () {
        expect(wrapper.findAll(PanelListItem).length).to.equal(propsData.value.length);
    });

    it("should display 'Not found' in '.panel-tabs' class if search query returns 0 entries", function () {
        expect(wrapper.find(".panel-tabs.not-found").exists()).to.not.be.true;
        wrapper.setData({searchQuery: "ABCDE"});
        expect(wrapper.find(".panel-tabs.not-found").exists()).to.be.true;
        expect(wrapper.find(".panel-tabs.not-found").text()).to.equal("Not found");
    });

    it("should display 'Nothing available' if available list of items is empty", function () {
        wrapper.setProps({value: []});
        expect(wrapper.findAll(PanelListItem).length).to.equal(0);
        expect(wrapper.find(".panel-tabs.not-found").exists()).to.be.true;
        expect(wrapper.find(".panel-tabs.not-found").text()).to.equal("Nothing available");
    });

    it("should display add button as third nav item if addButton prop is true", function () {
        expect(wrapper.findAll("nav").length).to.equal(2);
        wrapper.setProps({addButton: true});
        expect(wrapper.findAll("nav").length).to.equal(3);
    });

    it("should display full-width add button if addButton prop is true", function () {
        wrapper.setProps({addButton: true});
        let button = wrapper.find(".panel-block > button.button.is-info.is-fullwidth.is-outlined");
        expect(button.exists()).to.be.true;
    });
    it("should display plus MDI icon for add button", function () {
        wrapper.setProps({addButton: true});
        let button = wrapper.find(".button > i.mdi.mdi-plus");
        expect(button.exists()).to.be.true;
    });

    it("should emit 'add' if add button is clicked", function () {
        wrapper.setProps({addButton: true});
        expect(wrapper.emitted().add).to.be.undefined;
        wrapper.find(".button").trigger("click");
        expect(wrapper.emitted().add.length).to.equal(1);
    });

    it("should emit 'remove' if list item component emits 'remove'", function () {
        expect(wrapper.emitted().remove).to.be.undefined;
        wrapper.find(PanelListItem).vm.$emit("remove");
        expect(wrapper.emitted().remove.length).to.equal(1);
    });

    it("should emit 'input' if list item component emits 'click'", function () {
        expect(wrapper.emitted().input).to.be.undefined;
        wrapper.find(PanelListItem).vm.$emit("click");
        expect(wrapper.emitted().input.length).to.equal(1);
    });

    it("should pass itemIcon prop to all PanelListItem", function () {
        wrapper.setProps({itemIcon: "icon"});
        let wrappers = wrapper.findAll(PanelListItem);
        expect(wrappers.length).to.be.at.least(1);
        for (let i = 0; i < wrappers.length; i++) {
            expect(wrappers.at(i).props().itemIcon).to.equal("icon");
        }
    });

    it("should have listItem component prop that replaces PanelListSearch", function () {
        let item = "test-component";
        wrapper.setProps({listItem: item});
        expect(wrapper.findAll(PanelListItem).length).to.equal(0);
        expect(wrapper.findAll(item).length).to.equal(propsData.value.length);
    });

    it("should set is-active class if selectedItem prop equals item in item list", function () {
        wrapper.setProps({selectedItem: propsData.value[0]});
        let actives = wrapper.findAll(".is-active");
        expect(actives.length).to.equal(1);
        expect(actives.at(0).props().item).to.equal(propsData.value[0]);
    });
});
