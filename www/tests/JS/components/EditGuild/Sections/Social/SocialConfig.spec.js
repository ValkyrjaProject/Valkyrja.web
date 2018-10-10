import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import SocialConfig from "components/EditGuild/Sections/Social/SocialConfig";

let localVue = Vue.use(Vuex);

describe("SocialConfig", function () {
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
        wrapper = shallowMount(SocialConfig, {propsData, store, localVue});
    });

    it("should display 'memo_enabled' as VuexSwitch");

    it("should display 'profile_enabled' as VuexSwitch");

    it("should display 'exp_member_roleid' as VuexMultiselect");

    it("should display 'exp_member_messages' as VuexNumber");

    it("should display 'exp_enabled' as VuexSwitch");

    it("should display 'exp_announce_levelup' as VuexSwitch");

    it("should display 'base_exp_to_levelup' as VuexNumber");

    it("should display 'exp_per_message' as VuexNumber");

    it("should display 'exp_per_attachment' as VuexNumber");

    it("should display 'exp_max_level' as VuexNumber");

    it("should display LevelSelector component");

    it("should display 'exp_cumulative_roles' as VuexSwitch");

    it("should display 'exp_advance_users' as VuexSwitch");

    it("should display 'karma_per_level' as VuexNumber");

    it("should display 'karma_enabled' as VuexSwitch");

    it("should display 'karma_currency' as VuexText");

    it("should display 'karma_currency_singular' as VuexText");

    it("should display 'karma_consume_command' as VuexText");

    it("should display 'karma_consume_verb' as VuexText");

    it("should display 'karma_limit_mentions' as VuexNumber");

    it("should display 'karma_limit_minutes' as VuexNumber");

    it("should display 'karma_limit_response' as VuexSwitch");
});
