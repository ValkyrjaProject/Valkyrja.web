import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import PanelList from "components/shared/structure/PanelList/PanelList";

let localVue = Vue.use(Vuex);

describe("PanelList", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;

    beforeEach(function () {
        propsData = {};

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

    it("should have two nav elements under root element");

    it("should have '.panel-parent' class on first nav element");

    it("should have '.is-fixed-height' and '.has-background-white' classes on first nav element");

    it("should have '.panel-heading' under '.panel-parent' with title prop displayed");

    it("should display PanelListSearch component in '.panel-parent' under '.panel-heading'");

    it("should display PanelListItem component for each entry in searchedList");

    it("should display 'Not found' with '.panel-tabs' class if search query returns 0 entries");

    it("should display empty list if available list of items is empty");
});
