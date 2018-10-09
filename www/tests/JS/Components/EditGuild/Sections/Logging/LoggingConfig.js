import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import LoggingConfig from "components/EditGuild/Sections/Logging/LoggingConfig";

let localVue = Vue.use(Vuex);

describe("LoggingConfig", function () {
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
        wrapper = shallowMount(LoggingConfig, {propsData, store, localVue});
    });

    it("should display 'mod_channelid' as VuexMultiselect");

    it("should display 'embed_modchannel' as VuexSwitch");

    it("should display 'log_bans' as VuexSwitch");

    it("should display 'color_modchannel' as ColorPicker");

    it("should display 'log_warnings' as VuexSwitch");

    it("should display 'color_logwarning' as ColorPicker");

    it("should display 'log_channelid' as VuexMultiselect");

    it("should display 'embed_logchannel' as VuexSwitch");

    it("should display 'log_editedmessages' as VuexSwitch");

    it("should display 'log_deletedmessages' as VuexSwitch");

    it("should display 'color_logmessages' as ColorPicker");

    it("should display 'log_promotions' as VuexSwitch");

    it("should display 'voice_channelid' as ColorPicker");

    it("should display 'embed_voicechannel' as VuexSwitch");

    it("should display 'color_voicechannel' as ColorPicker");

    it("should display 'activity_channelid' as VuexMultiselect");

    it("should display 'embed_activitychannel' as VuexSwitch");

    it("should display 'color_activitychannel' as ColorPicker");

    it("should display 'log_join' as VuexSwitch");

    it("should display 'log_message_join' as VuexTextarea");

    it("should display 'log_mention_join' as VuexSwitch");

    it("should display 'log_timestamp_join' as VuexSwitch");

    it("should display 'log_leave' as VuexSwitch");

    it("should display 'log_message_leave' as VuexTextarea");

    it("should display 'log_mention_leave' as VuexSwitch");

    it("should display 'log_timestamp_leave' as VuexSwitch");

    it("should display IgnoredChannels component");
});

