import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import PanelListSearch from "components/shared/structure/PanelList/PanelListSearch";

let localVue = Vue.use(Vuex);

describe("PanelListSearch", function () {
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
        wrapper = shallowMount(PanelListSearch, {propsData, store, localVue});
    });

    it("should have div.panel-block as root element");

    it("should have one child with .field.has-addons.control classes under .panel-block");

    it("should have two .control children under .has-addons");

    it("should have a small full-width search input on left side");

    it("should have 'Search' as placeholder for search input");

    it("should emit 'input' on search input change");

    it("should have a small magnifying class search input on left side of input");

    it("should have a small close button on right side with .is-info class");

    it("should emit 'clear' on close button click");

    it("should have cross icon for close button");
});
