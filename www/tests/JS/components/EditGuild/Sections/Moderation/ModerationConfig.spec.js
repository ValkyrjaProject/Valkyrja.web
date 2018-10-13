import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import ModerationConfig from "components/EditGuild/Sections/Moderation/ModerationConfig";
import RoleSelector from "components/EditGuild/Sections/Moderation/RoleSelector/RoleSelector";
import {expectInput} from "../helper";
import VuexTextarea from "components/EditGuild/Vuex/VuexTextarea";
import VuexNumber from "components/EditGuild/Vuex/VuexNumber";
import VuexMultiselect from "components/EditGuild/Vuex/VuexMultiselect";

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
        wrapper = shallowMount(ModerationConfig, {propsData, store, localVue});
    });

    it("should display RoleSelector", function() {
        expect(wrapper.find(RoleSelector).exists()).to.equal(true);
    });

    it("should display 'operator_roleid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "operator_roleid");
    });

    it("should display 'quickban_reason' as VuexTextarea", function () {
        expectInput(wrapper, VuexTextarea, "quickban_reason");
    });

    it("should display 'quickban_duration' as VuexNumber", function () {
        expectInput(wrapper, VuexNumber, "quickban_duration");
    });

    it("should display 'mute_roleid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "mute_roleid");
    });

    it("should display 'mute_ignore_channelid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "mute_ignore_channelid");
    });

    it("should display 'mute_ignore_channelid' as VuexMultiselect", function () {
        expectInput(wrapper, VuexMultiselect, "mute_ignore_channelid");
    });

    it("should have 'Moderation Guidelines' link that should open in new tab/window", function () {
        let link = wrapper.find("a[href=\"http://rhea-ayase.eu/articles/2017-04/Moderation-guidelines\"]");
        expect(link.exists()).to.equal(true);
        expect(link.text()).to.equal("Moderation Guidelines");
        expect(link.attributes("target")).to.equal("_blank");
    });

    it("should have 'On the topic of Moderation' link that should open in new tab/window", function () {
        let link = wrapper.find("a[href=\"http://rhea-ayase.eu/articles/2016-11/On-the-topic-of-moderation\"]");
        expect(link.exists()).to.equal(true);
        expect(link.text()).to.equal("On the topic of Moderation");
        expect(link.attributes("target")).to.equal("_blank");
    });
});
