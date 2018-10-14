import sinon from "sinon";
import {shallowMount} from "@vue/test-utils";
import Vue from "vue";
import Vuex from "vuex";
import {expect} from "chai";
import VuexMultiselect from "components/EditGuild/Vuex/VuexMultiselect";
import VueMultiselect from "vue-multiselect";

let localVue = Vue.use(Vuex);

describe("VuexMultiselect", function () {
    let wrapper;
    let actions;
    let store;
    let state;
    let getters;
    let propsData;
    let inputValue;
    let configInput;

    beforeEach(function () {
        propsData = {
            storeName: "name",
            optionName: "option"
        };
        actions = {
            changeConfig: sinon.stub()
        };
        state = {
            guild: {
                option: [{id: "option1"}, {id: "option2"}]
            }
        };
        inputValue = {value: state.guild.option.id};
        configInput = sinon.stub();
        configInput.returns(inputValue);
        getters = {
            configInput: () => configInput,
        };
        store = new Vuex.Store({
            namespaced: true,
            state,
            actions,
            getters
        });
        wrapper = shallowMount(VuexMultiselect, {propsData, store, localVue});
    });

    it("should have VuexMultiselect name", function () {
        expect(wrapper.name()).to.equal("VuexMultiselect");
    });

    it("should have a VueMultiselect component as node", function () {
        expect(wrapper.find(VueMultiselect).exists()).to.be.true;
    });

    it("should have required string storeName prop", function () {
        expect(wrapper.vm.$props.storeName).to.equal(propsData.storeName);
    });

    it("should have required string optionName prop", function () {
        expect(wrapper.vm.$props.optionName).to.equal(propsData.optionName);
    });

    it("should have optional string placeholder prop", function () {
        expect(wrapper.vm.$props.placeholder).to.equal("Select option");
    });

    it("should send default 'Select option' to VueMultiselect if placeholder prop is not set", function () {
        expect(wrapper.find(VueMultiselect).attributes().placeholder).to.equal("Select option");
    });

    it("should send placeholder prop value to VueMultiselect", function () {
        wrapper.setProps({placeholder: "Placeholder"});
        expect(wrapper.find(VueMultiselect).attributes().placeholder).to.equal("Placeholder");
    });

    it("should send empty to VueMultiselect if state.guild[this.optionName] is null/undefined", function () {
        state.guild.option = null;
        expect(wrapper.vm.options).to.deep.equal([]);
        expect(wrapper.find(VueMultiselect).attributes().options).to.equal("");
        state.guild.option = undefined;
        expect(wrapper.vm.options).to.deep.equal([]);
        expect(wrapper.find(VueMultiselect).attributes().options).to.equal("");
    });

    it("should send 'options' array to VueMultiselect if state.guild[this.optionName] is has array fields", function () {
        expect(wrapper.vm.options).to.deep.equal(state.guild.option);
    });

    it("should send selected option to VueMultiselect if it exists in 'options' array", function () {
        expect(wrapper.vm.inputValue).to.deep.equal(state.guild.option.find(obj => {
            return obj.id === inputValue.value;
        }));
    });

    it("should send undefined as selected option to VueMultiselect if it doesn't exist in 'options' array", function () {
        inputValue = {value: "test"};
        expect(wrapper.find(VueMultiselect).attributes().value).to.equal(undefined);
    });

    it("should dispatch changeConfig with null when selected option is deselected", function () {
        wrapper.vm.inputValue = null;
        expect(actions.changeConfig.getCall(0).args[1]).to.contain({
            storeName: propsData.storeName,
            value: null
        });
    });

    it("should dispatch changeConfig with newly selected option's id field", function () {
        wrapper.vm.inputValue = {id: "option2"};
        expect(actions.changeConfig.getCall(0).args[1]).to.contain({
            storeName: propsData.storeName,
            value: "option2"
        });
    });
});
