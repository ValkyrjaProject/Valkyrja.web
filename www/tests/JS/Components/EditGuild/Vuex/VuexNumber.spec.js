import sinon from "sinon";
import {shallowMount} from '@vue/test-utils'
import Vue from 'vue';
import Vuex from "vuex";
import {expect} from "chai";
import VuexNumber from "components/EditGuild/Vuex/VuexNumber"

let localVue = Vue.use(Vuex);

describe('VuexNumber', function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;
    let inputValue = "5";

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
        wrapper = shallowMount(VuexNumber, {propsData, store, localVue});
    });

    it('should have input field of type number by default', function () {
        expect(wrapper.find('input[type="number"]').exists()).to.equal(true);
    });

    it('should have input field of type number if typeInteger is true', function () {
        wrapper.setProps({typeInteger: true});
        expect(wrapper.find('input[type="number"]').exists()).to.equal(true);
    });

    it('should have input field of type text if typeInteger is false', function () {
        wrapper.setProps({typeInteger: false});
        expect(wrapper.find('input[type="text"]').exists()).to.equal(true);
    });

    it('should have id with storeName value', function () {
        expect(wrapper.find(`input[id="${propsData.storeName}"]`).exists()).to.equal(true);
    });

    it('should have name attribute for storeName', function () {
        expect(wrapper.find(`input[name="${propsData.storeName}"]`).exists()).to.equal(true);
    });

    it('should display value in input', function () {
        expect(wrapper.find('input').element.value).to.equal(inputValue);
    });

    it('should dispatch changeConfig on input change', function () {
        wrapper.find("input").setValue("4");
        sinon.assert.calledOnce(actions.changeConfig);
    });

    it('should retrieve value from configInput getter', function () {
        sinon.assert.calledOnce(getters.configInput());
    });

    it('should have min field if min prop is set', function () {
        let number = 5;
        expect(wrapper.find(`input[min="${number}"`).exists()).to.equal(false);
        wrapper.setProps({min: number});
        expect(wrapper.find(`input[min="${number}"`).exists()).to.equal(true);
    });

    it('should have max field if max prop is set', function () {
        let number = 5;
        expect(wrapper.find(`input[max="${number}"`).exists()).to.equal(false);
        wrapper.setProps({max: number});
        expect(wrapper.find(`input[max="${number}"`).exists()).to.equal(true);
    });
});