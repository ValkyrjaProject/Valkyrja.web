import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import VuexTextarea from "components/EditGuild/Vuex/VuexTextarea";

let localVue = Vue.use(Vuex);

describe("VuexTextarea", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;
    let inputValue = "input value";

    beforeEach(function () {
        propsData = {
            storeName: "name"
        };

        let changeConfig = sinon.spy();
        actions = {
            changeConfig: changeConfig
        };
        state = {};

        let configInput = sinon.stub();
        configInput.returns(inputValue);
        getters = {
            configInput: () => configInput
        };
        store = new Vuex.Store({
            state,
            actions,
            getters
        });
        wrapper = shallowMount(VuexTextarea, {propsData, store, localVue});
    });

    it("should have textarea field", function () {
        expect(wrapper.find("textarea").exists()).to.equal(true);
    });

    it("should have name attribute for storeName", function () {
        expect(wrapper.find(`textarea[name="${propsData.storeName}"]`).exists()).to.equal(true);
    });

    it("should have id with storeName value", function () {
        expect(wrapper.find(`textarea[id="${propsData.storeName}"]`).exists()).to.equal(true);
    });

    it("should display value in input", function () {
        expect(wrapper.find("textarea").element.value).to.equal(inputValue);
    });

    it("should dispatch changeConfig on input change", function () {
        wrapper.find("textarea").setValue("new value");
        sinon.assert.calledOnce(actions.changeConfig);
    });

    it("should retrieve value from configInput getter", function () {
        sinon.assert.calledOnce(getters.configInput());
    });
});
