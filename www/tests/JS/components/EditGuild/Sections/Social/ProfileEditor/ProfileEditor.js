import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import ProfileEditor from "components/EditGuild/Sections/Social/ProfileEditor/ProfileEditor";

let localVue = Vue.use(Vuex);

describe("ProfileEditor", function () {
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
        wrapper = shallowMount(ProfileEditor, {propsData, store, localVue});
    });

    it("should ");
});
