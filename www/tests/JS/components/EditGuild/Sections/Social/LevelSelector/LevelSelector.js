import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import LevelSelector from "components/EditGuild/Sections/Social/LevelSelector/LevelSelector";

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

        actions = {};
        state = {};
        getters = {};
        store = new Vuex.Store({
            state,
            actions,
            getters
        });
        wrapper = shallowMount(LevelSelector, {propsData, store, localVue});
    });

    it("should have available roles on left column");
    it("should have stacked levels and added roles on right column");
});
