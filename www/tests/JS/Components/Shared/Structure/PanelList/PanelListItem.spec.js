import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import PanelListItem from "components/shared/structure/PanelList/PanelListItem";

let localVue = Vue.use(Vuex);

describe("PanelListItem", function () {
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
        wrapper = shallowMount(PanelListItem, {propsData, store, localVue});
    });

    it("should have 'a' as root-element");

    it("should emit 'click' with item on root-element click");

    it("should have optional 'itemIcon' prop");

    it("should have required 'item' prop");

    it("should have Material Design icon on left side if itemIcon prop is set");

    it("should shorten 'item' toString value to 25 characters directly under root-element");

    it("should trim whitespace of 'item' toString");
});
