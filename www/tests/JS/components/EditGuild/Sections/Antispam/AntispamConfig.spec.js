import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import AntispamConfig from "components/EditGuild/Sections/Antispam/AntispamConfig";
import {expectInput} from "../helper";
import VuexSwitch from "components/EditGuild/Vuex/VuexSwitch";
import VuexNumber from "components/EditGuild/Vuex/VuexNumber";

let localVue = Vue.use(Vuex);

describe("AntispamConfig", function () {
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
        wrapper = shallowMount(AntispamConfig, {propsData, store, localVue});
    });

    it("should display antispam_ignore_members as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_ignore_members");
    });

    it("should display antispam_tolerance as vuex-number with minimum value", function () {
        expectInput(wrapper, VuexNumber, "antispam_tolerance");
    });

    it("should display antispam_invites as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_invites");
    });

    it("should display antispam_invites_ban as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_invites_ban");
    });

    it("should display antispam_duplicate as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_duplicate");
    });

    it("should display antispam_duplicate_crossserver as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_duplicate_crossserver");
    });

    it("should display antispam_duplicate_ban as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_duplicate_ban");
    });

    it("should display antispam_mentions_max as vuex-number", function () {
        expectInput(wrapper, VuexNumber, "antispam_mentions_max");
    });

    it("should display antispam_mentions_ban as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_mentions_ban");
    });

    it("should display antispam_mute as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_mute");
    });

    it("should display antispam_mute_duration as vuex-number with minimum value", function () {
        expectInput(wrapper, VuexNumber, "antispam_mute_duration");
    });

    it("should display antispam_links_youtube as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_youtube");
    });

    it("should display antispam_links_youtube_ban as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_youtube_ban");
    });

    it("should display antispam_links_twitch as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_twitch");
    });

    it("should display antispam_links_twitch_ban as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_twitch_ban");
    });

    it("should display antispam_links_hitbox as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_hitbox");
    });

    it("should display antispam_links_beam as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_beam");
    });

    it("should display antispam_links_beam_ban as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_beam_ban");
    });

    it("should display antispam_links_imgur as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_imgur");
    });

    it("should display antispam_links_imgur_ban as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_imgur_ban");
    });

    it("should display antispam_links_standard as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_standard");
    });

    it("should display antispam_links_standard_ban as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_standard_ban");
    });

    it("should display antispam_links_extended as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_extended");
    });

    it("should display antispam_links_extended_ban as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_links_extended_ban");
    });

    it("should display antispam_voice_switching as vuex-switch", function () {
        expectInput(wrapper, VuexSwitch, "antispam_voice_switching");
    });

    it("should call configInput", function () {
        expect(getters.configInput().called).to.equal(true);
    });

    it("should retrieve command_prefix from configInput", function () {
        expect(getters.configInput().withArgs("command_prefix").called).to.equal(true);
    });

    it("should retrieve antispam_tolerance from configInput", function () {
        expect(getters.configInput().withArgs("antispam_tolerance").called).to.equal(true);
    });
});