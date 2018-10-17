import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import SocialConfig from "components/EditGuild/Sections/Social/SocialConfig";
import {expectInput} from "../helper";
import VuexSwitch from "components/EditGuild/Vuex/VuexSwitch";
import VuexText from "components/EditGuild/Vuex/VuexText";
import VuexNumber from "components/EditGuild/Vuex/VuexNumber";
import VuexMultiselect from "components/EditGuild/Vuex/VuexMultiselect";
import VuexTextarea from "components/EditGuild/Vuex/VuexTextarea";
import ProfileEditor from "components/EditGuild/Sections/Social/ProfileEditor/ProfileEditor";
import LevelSelector from "components/EditGuild/Sections/Social/LevelSelector/LevelSelector";

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
        wrapper = shallowMount(SocialConfig, {propsData, store, localVue});
    });

    it("should display 'memo_enabled' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "memo_enabled");
    });

    it("should display 'profile_enabled' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "profile_enabled");
    });

    it("should display ProfileEditor component", function () {
        expect(wrapper.find(ProfileEditor).exists()).to.equal(true);
    });

    it("should display 'exp_member_roleid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "exp_member_roleid");
    });

    it("should display 'exp_member_messages' as VuexNumber", function () {
        expectInput(wrapper, VuexNumber, "exp_member_messages");
    });

    it("should display 'exp_enabled' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "exp_enabled");
    });

    it("should display 'exp_announce_levelup' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "exp_announce_levelup");
    });

    it("should display 'base_exp_to_levelup' as VuexNumber", function () {
        expectInput(wrapper, VuexNumber, "base_exp_to_levelup");
    });

    it("should display 'exp_per_message' as VuexNumber", function () {
        expectInput(wrapper, VuexNumber, "exp_per_message");
    });

    it("should display 'exp_per_attachment' as VuexNumber", function () {
        expectInput(wrapper, VuexNumber, "exp_per_attachment");
    });

    it("should display 'exp_max_level' as VuexNumber", function () {
        expectInput(wrapper, VuexNumber, "exp_max_level");
    });

    it("should display LevelSelector component", function () {
        expect(wrapper.find(LevelSelector).exists()).to.equal(true);
    });

    it("should display 'exp_cumulative_roles' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "exp_cumulative_roles");
    });

    it("should display 'exp_advance_users' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "exp_advance_users");
    });

    it("should display 'karma_per_level' as VuexNumber", function () {
        expectInput(wrapper, VuexNumber, "karma_per_level");
    });

    it("should display 'karma_enabled' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "karma_enabled");
    });

    it("should display 'karma_currency' as VuexText", function () {
        expectInput(wrapper, VuexText, "karma_currency");
    });

    it("should display 'karma_currency_singular' as VuexText", function () {
        expectInput(wrapper, VuexText, "karma_currency_singular");
    });

    it("should display 'karma_consume_command' as VuexText", function () {
        expectInput(wrapper, VuexText, "karma_consume_command");
    });

    it("should display 'karma_consume_verb' as VuexText", function () {
        expectInput(wrapper, VuexText, "karma_consume_verb");
    });

    it("should display 'karma_limit_mentions' as VuexNumber", function () {
        expectInput(wrapper, VuexNumber, "karma_limit_mentions");
    });

    it("should display 'karma_limit_minutes' as VuexNumber", function () {
        expectInput(wrapper, VuexNumber, "karma_limit_minutes");
    });

    it("should display 'karma_limit_response' as VuexSwitch", function () {
        expectInput(wrapper, VuexSwitch, "karma_limit_response");
    });
});
