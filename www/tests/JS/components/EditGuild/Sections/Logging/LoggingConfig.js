import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import LoggingConfig from "components/EditGuild/Sections/Logging/LoggingConfig";
import {expectInput} from "../helper";
import VuexSwitch from "components/EditGuild/Vuex/VuexSwitch";
import VuexNumber from "components/EditGuild/Vuex/VuexNumber";
import VuexMultiselect from "components/EditGuild/Vuex/VuexMultiselect";
import VuexTextarea from "components/EditGuild/Vuex/VuexTextarea";
import VuexColor from "components/EditGuild/Vuex/VuexColor";
import IgnoredChannels from "components/EditGuild/Sections/Logging/IgnoredChannels/IgnoredChannels";

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
        wrapper = shallowMount(LoggingConfig, {propsData, store, localVue});
    });

    it("should display 'mod_channelid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "mod_channelid");
    });

    it("should display 'embed_modchannel' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "embed_modchannel");
    });

    it("should display 'log_bans' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_bans");
    });

    it("should display 'color_modchannel' as VuexColor", function () {
        expectInput(wrapper, VuexColor, "color_modchannel");
    });

    it("should display 'log_warnings' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_warnings");
    });

    it("should display 'color_logwarning' as VuexColor", function () {
        expectInput(wrapper, VuexColor, "color_logwarning");
    });

    it("should display 'log_channelid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "log_channelid");
    });

    it("should display 'embed_logchannel' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "embed_logchannel");
    });

    it("should display 'log_editedmessages' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_editedmessages");
    });

    it("should display 'log_deletedmessages' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_deletedmessages");
    });

    it("should display 'color_logmessages' as VuexColor", function () {
        expectInput(wrapper, VuexColor, "color_logmessages");
    });

    it("should display 'log_promotions' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_promotions");
    });

    it("should display 'voice_channelid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "voice_channelid");
    });

    it("should display 'embed_voicechannel' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "embed_voicechannel");
    });

    it("should display 'color_voicechannel' as VuexColor", function () {
        expectInput(wrapper, VuexColor, "color_voicechannel");
    });

    it("should display 'activity_channelid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "activity_channelid");
    });

    it("should display 'embed_activitychannel' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "embed_activitychannel");
    });

    it("should display 'color_activitychannel' as VuexColor", function () {
        expectInput(wrapper, VuexColor, "color_activitychannel");
    });

    it("should display 'log_join' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_join");
    });

    it("should display 'log_message_join' as VuexTextarea", function () {
        expectInput(wrapper, VuexTextarea, "log_message_join");
    });

    it("should display 'log_mention_join' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_mention_join");
    });

    it("should display 'log_timestamp_join' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_timestamp_join");
    });

    it("should display 'log_leave' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_leave");
    });

    it("should display 'log_message_leave' as VuexTextarea", function () {
        expectInput(wrapper, VuexTextarea, "log_message_leave");
    });

    it("should display 'log_mention_leave' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_mention_leave");
    });

    it("should display 'log_timestamp_leave' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "log_timestamp_leave");
    });

    it("should display IgnoredChannels component", function () {
        expect(wrapper.find(IgnoredChannels).exists()).to.equal(true);
    });
});

