import {shallowMount} from '@vue/test-utils'
import Vue from 'vue';
import Vuex from "vuex";
import {expect} from "chai";
import BasicConfig from "components/EditGuild/Sections/BasicConfig/BasicConfig"
import VuexText from "components/EditGuild/Vuex/VuexText";
import VuexSwitch from "components/EditGuild/Vuex/VuexSwitch";
import {expectInput} from "../helper";

let localVue = Vue.use(Vuex);

describe('BasicConfig', function () {
    let wrapper;
    let propsData;

    beforeEach(function () {
        propsData = {};

        wrapper = shallowMount(BasicConfig, {propsData, localVue});
    });

    it('should display command_prefix as vuex-text', function () {
        expectInput(wrapper, VuexText, "command_prefix");
    });

    it('should display command_prefix_alt as vuex-text', function () {
        expectInput(wrapper, VuexText, "command_prefix_alt");
    });

    it('should display execute_on_edit as vuex-switch', function () {
        expectInput(wrapper, VuexSwitch, "execute_on_edit");
    });

    it('should display ignore_bots as vuex-switch', function () {
        expectInput(wrapper, VuexSwitch, "ignore_bots");
    });

    it('should display ignore_everyone as vuex-switch', function () {
        expectInput(wrapper, VuexSwitch, "ignore_everyone");
    });

});