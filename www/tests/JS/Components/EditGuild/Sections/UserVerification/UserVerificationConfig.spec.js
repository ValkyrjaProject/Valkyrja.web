import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import UserVerificationConfig from "components/EditGuild/Sections/UserVerification/UserVerificationConfig";

let localVue = Vue.use(Vuex);

describe("UserVerificationConfig", function () {
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
        wrapper = shallowMount(UserVerificationConfig, {propsData, store, localVue});
    });

    it("should display 'welcome_pm' as VuexSwitch");

    it("should display 'welcome_message' as VuexTextarea");

    it("should display 'welcome_roleid' as VuexMultiselect");

    it("should display 'verify' as VuexSwitch");

    it("should display 'verify_roleid' as VuexMultiselect");

    it("should display 'verify_message' as VuexTextarea");

    it("should display 'verify_on_welcome' as VuexSwitch");

    it("should display 'verify_karma' as VuexNumber");
});
