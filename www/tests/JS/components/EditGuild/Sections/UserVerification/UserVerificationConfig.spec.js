import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import UserVerificationConfig from "components/EditGuild/Sections/UserVerification/UserVerificationConfig";
import VuexSwitch from "components/EditGuild/Vuex/VuexSwitch";
import VuexTextarea from "components/EditGuild/Vuex/VuexTextarea";
import VuexMultiselect from "components/EditGuild/Vuex/VuexMultiselect";
import VuexNumber from "components/EditGuild/Vuex/VuexNumber";
import {expectInput} from "../helper";

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

        let stub = sinon.stub();
        stub.returnsThis();
        getters = {
            configInput: () => stub
        };
        store = new Vuex.Store({
            state,
            actions,
            getters
        });
        wrapper = shallowMount(UserVerificationConfig, {propsData, store, localVue});
    });

    it("should display 'welcome_pm' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "welcome_pm");
    });

    it("should display 'welcome_message' as VuexTextarea", function () {
        expectInput(wrapper, VuexTextarea, "welcome_message");
    });

    it("should display 'welcome_roleid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "welcome_roleid");
    });

    it("should display 'verify' as VuexSwitch", function () {
        expectInput(wrapper,VuexSwitch, "verify");
    });

    it("should display 'verify_roleid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "verify_roleid");
    });

    it("should display 'verify_message' as VuexTextarea", function () {
        expectInput(wrapper, VuexTextarea, "verify_message");
    });

    it("should display 'verify_on_welcome' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "verify_on_welcome");
    });

    it("should display 'verify_karma' as VuexNumber", function () {
        expectInput(wrapper, VuexNumber, "verify_karma");
    });
});
