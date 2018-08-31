import sinon from "sinon";
import {shallowMount} from '@vue/test-utils'
import Vue from 'vue';
import Vuex from "vuex";
import {expect} from "chai";
import VuexSwitch from "components/EditGuild/Vuex/VuexSwitch"

let localVue = Vue.use(Vuex);

describe('VuexSwitch', function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;
    let inputValue = false;
    let slotText;

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
        slotText = "slot text";
        let slots = {
                default: slotText
        };
        wrapper = shallowMount(VuexSwitch, {slots, propsData, store, localVue});
    });

    it('should have input id as name prop', function () {
        expect(wrapper.find(`input[id="${propsData.storeName}"]`).exists()).to.equal(true);
    });

    it('should have label that is connected to input', function () {
        expect(wrapper.find(`input[name="${propsData.storeName}"]`).exists()).to.equal(true);
        expect(wrapper.find(`label[for="${propsData.storeName}"]`).exists()).to.equal(true);
    });

    it('should have id with storeName value', function () {
        expect(wrapper.find(`input[id="${propsData.storeName}"]`).exists()).to.equal(true);
    });

    it('should dispatch changeConfig on input change', function () {
        wrapper.find("input").trigger("click");
        sinon.assert.calledOnce(actions.changeConfig);
    });

    it('should retrieve configInput when created', function () {
        sinon.assert.calledOnce(getters.configInput());
    });


    it('should dispatch storeName and value on change', function () {
        wrapper.find("input").trigger("click");
        expect(actions.changeConfig.getCall(0).args[1]).to.contain({
            storeName: propsData.storeName,
            value: + !inputValue
        });
    });

    it('should display unchecked when configInput is false', function () {
        expect(wrapper.find("input").element.checked).to.equal(inputValue);
    });

    it('should display checked when configInput is true', function () {
        wrapper.find("input").trigger("click");
        expect(wrapper.find("input").element.checked).to.equal(!inputValue);
    });

    it('should display slot in label', function () {
        expect(wrapper.find("label").text()).to.equal(slotText);
    });
});