import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import ModerationConfig from "components/EditGuild/Sections/Moderation/ModerationConfig";

let localVue = Vue.use(Vuex);

describe("ModerationConfig", function () {
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
        wrapper = shallowMount(ModerationConfig, {propsData, store, localVue});
    });

    it("should display RoleSelector");

    it("should display 'operator_roleid' as VuexMultiselect");

    it("should display 'quickban_reason' as VuexTextarea");

    it("should display 'quickban_duration' as VuexNumber");

    it("should display 'mute_roleid' as VuexMultiselect");

    it("should display 'mute_ignore_channelid' as VuexMultiselect");

    it("should display 'mute_ignore_channelid' as VuexMultiselect");

    it("should have 'Moderation Guidelines' link");

    it("should open 'Moderation Guidelines' link in new tab/window");

    it("should have 'On the topic of Moderation' link");

    it("should open 'On the topic of Moderation' link in new tab/window");
});
